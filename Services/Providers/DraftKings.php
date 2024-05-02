<?php

namespace Services\Providers;

class DraftKings extends AbstractProvider
{
    /**
     * @return array
     */
    public function extractEvents(): array
    {
        $events = [];

        foreach ($this->json['events'] as $event) {
            $homeTeam = trim($event['homeTeamName']);
            $awayTeam = trim($event['awayTeamName']);

            $events[] = [
                'id' => $event['id'],
                'sport' => $this->sport,
                'scheduled' => $event['startDate'], // we could strtotime here probably, but it will mess with filters
                'homeTeam' => $homeTeam,
                'awayTeam' => $awayTeam,
                'event_name' => $awayTeam . ' @ ' . $homeTeam,
            ];
        }

        return $events;
    }

    /**
     * @return array
     */
    public function extractOffers(): array
    {
        $offers = [];
        $projection = 8;
        foreach ($this->json['events'] as $event) {
            foreach ($event['offers'] as $offer) {
                if ($offer['label'] === 'Total') {
                    foreach ($offer['outcomes'] as $outcome) {
                        if (!(stripos($outcome['label'], 'over') === false && stripos(
                                $outcome['label'],
                                'under'
                            ) === false)) {
                            $line = (float)$outcome['line'];
                            $diff = $projection - $line;
                            $defaultBet = 'no_bet';

                            if ($diff > 0.5) {
                                $defaultBet = 'over';
                            } elseif ($diff < -0.5) {
                                $defaultBet = 'under';
                            }

                            $offers[] = [
                                'event_id' => $event['id'],
                                'label' => $offer['label'],
                                'projection' => $projection,
                                'recommendation' => $defaultBet,
                                'diff' => $diff,
                                'line' => $line,
                                'odds' => $outcome['oddsAmerican'],
                                'label_outcome' => $outcome['label'],
                            ];
                        }
                    }
                }
            }
        }

        return $offers;
    }
}
