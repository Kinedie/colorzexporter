<?php

namespace ColorzExporter\EventSubscriber\Event;

use Symfony\Contracts\EventDispatcher\Event;

class TeamsExportEvent extends Event
{
    public string $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }
}
