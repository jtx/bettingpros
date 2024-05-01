<?php

namespace Services;

class Processor
{
    /**
     * @param array $events
     * @param array $offers
     */
    public function __construct(protected array $events, protected array $offers) { }

    /**
     * @return false|string
     */
    public function process(): false|string
    {
        $output = ['events' => $this->events, 'offers' => []];
        foreach ($this->offers as $offer) {
            $diff = 8 - (float)$offer['line'];
            $recommendation = 'no_bet';

            if ($diff > 0.5) {
                $recommendation = 'over';
            } elseif ($diff < -0.5) {
                $recommendation = 'under';
            }

            $output['offers'][] = [
                'event_id' => $offer['event_id'],
                'label' => $offer['label'],
                'projection' => 8,
                'recommendation' => $recommendation,
                'diff' => $diff,
                'line' => $offer['line'],
                'odds' => $offer['odds'],
                'label_outcome' => $offer['label_outcome'],
            ];
        }

        return json_encode($output, JSON_PRETTY_PRINT);
    }
}
