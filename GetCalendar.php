<?php

require __DIR__ . '/vendor/autoload.php';

use Calendar\Enums\QueryType;
use Calendar\Services\EventLoader;
use Calendar\Domain\Event;

function help()
{
    $helpString = "\n" .'Welcome to the Calendar App!' . "\n";
    $helpString .= 'Use this script to check your calendar.' . "\n";
    $helpString .= 'To use it, call with "php GetCalendar.php [options]" to see all Events.' . "\n";
    $helpString .= 'You can also use it with "php GetCalendar.php [options]". Available options are: ' . "\n";
    $helpString .= '--after "m/d/Y"' . "\n";
    $helpString .= '--before "m/d/Y"' . "\n";
    $helpString .= '--at_least *Number Of Invitees*' . "\n";
    $helpString .= '--at_most *Number Of Invitees*' . "\n";
    $helpString .= 'These options can be used in combination as well.' . "\n";
    $helpString .= 'To see this again, use --help' . "\n";
    $helpString .= 'Enjoy!' . "\n\n";
    echo $helpString;
}

$opts = getopt('',
    [
        QueryType::AFTER . ':',
        QueryType::BEFORE . ':',
        QueryType::AT_LEAST . ':',
        QueryType::AT_MOST . ':',
        QueryType::HELP,
    ]);

$calendar = (new EventLoader())->loadEvents();

echo "\n";
try {

    foreach ($opts as $key => $opt) {

        switch ($key) {
            case QueryType::AFTER:
                echo 'Searched For: ' . QueryType::AFTER . ' '. $opt . "\n";
                $date = DateTime::createFromFormat('m/d/Y', $opt);
                $calendar = $calendar->getEventsAfterDate($date);
                break;
            case QueryType::BEFORE:
                echo 'Searched For: ' . QueryType::BEFORE . ' '. $opt . "\n";
                $date = DateTime::createFromFormat('m/d/Y', $opt);
                $calendar = $calendar->getEventsBeforeDate($date);
                break;
            case QueryType::AT_MOST:
                echo 'Searched For: ' . QueryType::AT_MOST . ' '. $opt . " people\n";
                $calendar = $calendar->getEventsWithAtMostSoManyPeople($opt);
                break;
            case QueryType::AT_LEAST:
                echo 'Searched For: ' . QueryType::AT_LEAST . ' '. $opt . " people\n";
                $calendar = $calendar->getEventsWithAtLeastSoManyPeople($opt);
                break;
            case QueryType::HELP:
                help();
                die;
            default:
                $calendar = $calendar->getAllEvents();
        }
    }

    $events = $calendar->getAllEvents();

    /** @var Event $event */
    foreach ($events as $event) {
        echo ("-------------------------\n");
        echo ("Occasion: {$event->getOccasion()}\n");
        echo ("Number of people invited: {$event->getInvitedCount()}\n");
        echo ("Date: {$event->getDate()->format('m/d/y')}\n\n");
    }
}
catch (Exception $e) {
    echo ($e->getMessage() . "\n\n");
}