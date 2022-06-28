<?php

namespace ColorzExporter\Service\Export;

use ColorzExporter\EventSubscriber\Event\MembersExportEvent;
use ColorzExporter\Exception\EmptyJsonInputFileException;
use ColorzExporter\Exception\NonExistingPowerException;
use ColorzExporter\Service\Export\Formatting\ListOfMembersFormatter;
use Psr\EventDispatcher\EventDispatcherInterface;
use function array_push;
use function count;
use function fclose;
use function fopen;
use function fputcsv;
use function max;

class MembersCsvExporter extends CsvExporter
{
    private ListOfMembersFormatter $formatter;

    public function __construct(ListOfMembersFormatter $formatter, EventDispatcherInterface $eventDispatcher)
    {
        parent::__construct($eventDispatcher);
        $this->formatter = $formatter;
    }

    /**
     * @throws EmptyJsonInputFileException|NonExistingPowerException
     */
    public function export(string $data): void
    {
        if ('{}' == $data){
            throw new EmptyJsonInputFileException('The JSON file is empty', 406);
        }

        $normalizedData = $this->normalize($data);
        $listOfFormattedMembers = $this->formatter->format($normalizedData);

        $prefix = 'teams_members_';
        $csvFilename = $this->defineCsvFilename($prefix);

        $processedCsv = fopen($csvFilename, 'w');
        fputcsv($processedCsv, $this->getColumns($listOfFormattedMembers));

        foreach ($listOfFormattedMembers as $row) {
            fputcsv($processedCsv, $row);
        }

        fclose($processedCsv);
        $this->shareData($csvFilename);
    }

    private function getColumns(array $listOfFormattedMembers): array
    {
        $listOfElementsLengths = [];

        foreach ($listOfFormattedMembers as $member){
            $listOfElementsLengths[] = count($member);
        }

        $numberOfColumnsForPowers = max($listOfElementsLengths) - 6;

        $csvColumns = [
            'Squad Name',
            'Home Town',
            'Name',
            'Secret ID',
            'Age',
            'Number Of Powers'
        ];

        $powerColumnIndex = 0;
        while ($powerColumnIndex < $numberOfColumnsForPowers) {
            $powerColumnIndex++;
            array_push($csvColumns, 'Power ' . $powerColumnIndex);
        }

        return $csvColumns;
    }

    private function shareData(string $csvFilename): void
    {
        $event = new MembersExportEvent($csvFilename);
        $this->eventDispatcher->dispatch($event);
    }
}
