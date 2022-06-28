<?php

namespace ColorzExporter\Service\Export;

use DateTime;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use function json_decode;

abstract class CsvExporter
{
    protected EventDispatcherInterface $eventDispatcher;

    abstract public function export(string $data): void;

    public function normalize(string $data): array
    {
        return json_decode($data, true)['teams'];
    }

    public function defineCsvFilename(string $prefix): string
    {
        $actualExportDate = new DateTime();
        $formattedExportDate = $actualExportDate->format('YmdHis');

        return $prefix . $formattedExportDate . '.csv';
    }
}
