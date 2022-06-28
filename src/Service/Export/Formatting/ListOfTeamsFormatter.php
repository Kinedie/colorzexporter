<?php

namespace ColorzExporter\Service\Export\Formatting;

use function count;
use function round;

class ListOfTeamsFormatter
{
    public function format(array $normalizedData): array
    {
        $formattedTeams = [];

        foreach ($normalizedData as $n) {
            $formattedTeams[] = [
                'squad name' => $n['squadName'],
                'home town' => $n['homeTown'],
                'formed year' => $n['formed'],
                'base' => $n['secretBase'],
                'is active' => $this->setActivityStatus($n['active']),
                'number of members' => count($n['members']),
                'average age' => $this->getMembersAverageAge($n)
            ];
        }

        return $formattedTeams;
    }

    private function setActivityStatus(bool $isActive): string
    {
        return $isActive ? 'yes' : 'no';
    }

    private function getMembersAverageAge(array $a): int
    {
        $averageAge = 0;

        if (!empty($a['members'])){
            $sumOfAges = 0;
            foreach ($a['members'] as $member){
                $sumOfAges += $member['age'];
            }
            $averageAge = round($sumOfAges / count($a['members']));
        }

        return $averageAge;
    }
}
