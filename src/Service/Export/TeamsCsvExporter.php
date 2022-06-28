<?php

namespace ColorzExporter\Service\Export;

use ColorzExporter\EventSubscriber\Event\TeamsExportEvent;
use ColorzExporter\Exception\EmptyJsonInputFileException;
use ColorzExporter\Service\Export\Formatting\ListOfTeamsFormatter;
use function fclose;
use function fopen;
use function fputcsv;

class TeamsCsvExporter extends CsvExporter
{
    private ListOfTeamsFormatter $formatter;

    public function __construct(ListOfTeamsFormatter $formatter)
    {
        $this->formatter = $formatter;
    }

    /**
     * @throws EmptyJsonInputFileException
     */
    public function export(string $data): void
    {
        if ('{}' == $data){
            throw new EmptyJsonInputFileException('The JSON file is empty', 406);
        }

        $normalizedData = $this->normalize($data);
        $listOfFormattedTeams = $this->formatter->format($normalizedData);

        $prefix = 'teams_';
        $csvFilename = $this->defineCsvFilename($prefix);

        $processedCsv = fopen($csvFilename, 'w');
        fputcsv($processedCsv,[
            'Squad Name',
            'Home Town',
            'Formed Year',
            'Base',
            'Is Active',
            'Number of Members',
            'Average Age'
        ]);

        foreach ($listOfFormattedTeams as $row) {
            fputcsv($processedCsv, $row);
        }

        fclose($processedCsv);
        $this->shareData($csvFilename);
    }

    private function shareData(string $csvFilename): void
    {
        $event = new TeamsExportEvent($csvFilename);
        $this->eventDispatcher->dispatch($event);
    }
}
