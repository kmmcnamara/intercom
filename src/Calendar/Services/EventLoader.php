<?php

namespace Calendar\Services;

use Calendar\Domain\Calendar;
use Calendar\Domain\Event;
use DateTime;

class EventLoader
{
    const FILE_LOCATION =  __DIR__ . "/../data/Events.json";

    const EVENTS        = 'events';
    const OCCASION      = 'occasion';
    const INVITED_COUNT = 'invited_count';
    const YEAR          = 'year';
    const MONTH         = 'month';
    const DAY           = 'day';

    private $fileLoader;

    public function __construct(FileLoader $fileLoader = null)
    {
        if (!$fileLoader instanceof FileLoader) {
            $fileLoader = new FileLoader();
        }
        $this->fileLoader = $fileLoader;
    }

    /**
     * @return Calendar
     */
    public function loadEvents()
    {
        $eventJson = $this->getFileLoader()->loadFile(self::FILE_LOCATION);
        $eventData = json_decode($eventJson, true);
        $loadedEvents = [];

        $eventData = $eventData[self::EVENTS];

        foreach($eventData as $event) {
            $occasion = $event[self::OCCASION];
            $invitedCount = (int)$event[self::INVITED_COUNT];
            $year = $event[self::YEAR];
            $month = $event[self::MONTH];
            $day = $event[self::DAY];
            $dateString = $month . '/' . $day . '/' . $year;
            $date = DateTime::createFromFormat('m/d/Y', $dateString);

            $loadedEvents[] = new Event($occasion, $invitedCount, $date);
        }

        $calendar = new Calendar($loadedEvents);
        return $calendar;
    }

    /**
     * @return FileLoader
     */
    public function getFileLoader()
    {
        return $this->fileLoader;
    }
}