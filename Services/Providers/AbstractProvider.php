<?php

namespace Services\Providers;

use Enums\SportEnum;

abstract class AbstractProvider
{
    protected SportEnum $sport;
    /**
     * @var array|mixed
     */
    protected array $json;

    /**
     * @param \Enums\SportEnum $sport
     * @param string           $file
     */
    public function __construct(SportEnum $sport, string $file)
    {
        try {
            $this->sport = $sport;
            // These won't throw an exception. I need to do checks and throw exceptions if null / false
            $file = file_get_contents($file);
            $this->json = json_decode($file, true);
        } catch (\Throwable $e) {
            echo $e->getMessage() . "\n";
            exit;
        }
    }

    abstract public function extractEvents(): array;

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
     * @param array $events
     * @param       $team
     *
     * @return array
     */
    public function filterByTeam(array $events, $team): array
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
