<?php

namespace Services;

use Services\Providers\AbstractProvider;

class Processor
{
    /**
     * @param \Services\Providers\AbstractProvider $provider
     * @param array                                $opts
     */
    public function __construct(protected AbstractProvider $provider, protected array $opts = []) { }

    /**
     * @return false|string
     */
    public function process(): false|string
    {
        $events = $this->provider->extractEvents();

        // Optional date filtering
        if (!empty($this->opts['date'])) {
            $events = $this->provider->filterByDate($events, $this->opts['date']);
        }

        // Optional team filtering
        if (!empty($this->opts['team'])) {
            $events = $this->provider->filterByTeam($events, $this->opts['team']);
        }

        $offers = $this->provider->extractOffers();
        $offers = $this->provider->getFilteredOffers($events, $offers);
        $output = ['events' => $events, 'offers' => $offers];

        return json_encode($output, JSON_PRETTY_PRINT);
    }
}
