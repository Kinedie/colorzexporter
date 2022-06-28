<?php

namespace ColorzExporter\Service\Export\Formatting;

use ColorzExporter\Exception\NonExistingPowerException;
use ColorzExporter\Service\Export\Formatting\PowerInterpreter;
use function array_filter;
use function array_key_last;
use function count;

class ListOfMembersFormatter
{
    private PowerInterpreter $interpreter;

    public function __construct(PowerInterpreter $interpreter)
    {
        $this->interpreter = $interpreter;
    }

    /**
     * @throws NonExistingPowerException
     */
    public function format(array $normalizedTeams): array
    {
        $listOfProcessedTeams = [];

        foreach ($normalizedTeams as $normalizedTeam){
            $listOfProcessedTeams[] = $this->processTeam($normalizedTeam);
        }

        $listOfProcessedTeams = array_filter($listOfProcessedTeams);
        $listOfFormattedMembers = [];

        foreach ($listOfProcessedTeams as $processedTeam){
            for ($i = 0; $i < count($processedTeam); $i++){
                $listOfFormattedMembers[] = $processedTeam[$i];
            }
        }

        return $listOfFormattedMembers;
    }

    /**
     * @throws NonExistingPowerException
     */
    private function processTeam(array $team): array
    {
        $processedTeam = [];

        if (!empty($team['members'])){
            foreach ($team['members'] as $member){
                $processedTeam[] = [
                    'squad name' => $team['squadName'],
                    'home town' => $team['homeTown'],
                    'name' => $member['name'],
                    'secret identity' => $member['secretIdentity'],
                    'age' => $member['age'],
                    'number of powers' => $this->getNumberOfPowers($member),
                ];

                $powerIndex = 0;
                foreach ($member['powers'] as $power){
                    $powerIndex++;
                    $powerKey = 'power ' . $powerIndex;
                    $processedTeam[array_key_last($processedTeam)] += [$powerKey => $this->getPowerCode($power)];
                }
            }
        }

        return $processedTeam;
    }

    private function getNumberOfPowers(array $member): int
    {
        $numberOfPowers = 0;

        if (!empty($member['powers'])) {
            $numberOfPowers = count($member['powers']);
        }

        return $numberOfPowers;
    }

    /**
     * @throws NonExistingPowerException
     */
    private function getPowerCode(string $power): string
    {
        return $this->interpreter->getPowerCode($power);
    }
}
