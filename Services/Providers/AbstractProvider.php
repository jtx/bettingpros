<?php

namespace Services\Providers;

use CustomExceptions\InvalidFileException;
use CustomExceptions\InvalidJsonException;
use Enums\SportEnum;

abstract class AbstractProvider
{
    /**
     * @var \Enums\SportEnum
     */
    protected SportEnum $sport;
    /**
     * @var array|mixed
     */
    protected array $json;

    const PROJECTION = 8;   // be honest with you, is this just over/under average? Not sure

    /**
     * @param \Enums\SportEnum $sport
     * @param string           $file
     */
    public function __construct(SportEnum $sport, string $file)
    {
        $this->sport = $sport;

        try {
            if (!file_exists($file)) {
                throw new InvalidFileException("File {$file} does not exist!" . PHP_EOL);
            }

            $file = file_get_contents($file);
            $this->json = json_decode($file, true);
            if ($this->json === null) {
                throw new InvalidJsonException("File {$file} is not valid JSON!" . PHP_EOL);
            }
        } catch (\Throwable $e) {
            echo $e->getMessage() . PHP_EOL;
            exit;
        }
    }

    /**
     * @return array
     */
    abstract public function extractEvents(): array;

    /**
     * @return array
     */
    abstract public function extractOffers(): array;

    /**
     * Filter by date.... as the method name implies
     *
     * @param array  $events
     * @param string $date
     *
     * @return array
     */
    public function filterByDate(array $events, string $date): array
    {
        return array_filter($events, function ($event) use ($date) {
            return stripos($event['scheduled'], $date) !== false;
        });
    }

    /**
     * Filter by team.... as the method name implies
     *
     * @param array  $events
     * @param string $team
     *
     * @return array
     */
    public function filterByTeam(array $events, string $team): array
    {
        return array_filter($events, function ($event) use ($team) {
            return stripos($event['homeTeam'], $team) !== false || stripos($event['awayTeam'], $team) !== false;
        });
    }

    /**
     * @param array $events
     * @param array $offers
     *
     * @return array
     */
    public function getFilteredOffers(array $events, array $offers): array
    {
        $eventIds = array_column($events, 'id');

        return array_filter($offers, function ($offer) use ($eventIds) {
            return in_array($offer['event_id'], $eventIds);
        });
    }
}
