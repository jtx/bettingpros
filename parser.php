<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use CustomExceptions\InvalidProviderException;
use Services\Processor;
use Enums\SportEnum;
use CustomExceptions\InvalidSportException;
use CustomExceptions\InvalidOptionsException;

try {
    $opts = getopt('', ['sport:', 'filename:', 'provider:', 'date::', 'team::']);
    if (!isset($opts['sport']) || !isset($opts['filename']) || !isset($opts['provider'])) {
        throw new InvalidOptionsException(
            'Usage: php parser.php --sport=sport --filename=filename --provider=provider' . PHP_EOL
        );
    }

    $sportEnum = SportEnum::tryFrom(strtoupper($opts['sport']));
    if ($sportEnum === null) {
        throw new InvalidSportException("{$opts['sport']} is not a valid sport type!" . PHP_EOL);
    }

    $provider = "Services\\Providers\\{$opts['provider']}";
    if (!class_exists($provider)) {
        throw new InvalidProviderException("{$opts['provider']} does not exist!");
    }

    $provider = new $provider($sportEnum, __DIR__ . '/Data/' . $opts['filename']);

    $processor = new Processor($provider, $opts);
    $res = $processor->process();
    if ($res === false) {
        throw new \Exception('Unknown Error');
    }

    echo $res . PHP_EOL;
} catch (Throwable $e) {
    // log something probably before this?
    echo $e->getMessage() . PHP_EOL;
}
