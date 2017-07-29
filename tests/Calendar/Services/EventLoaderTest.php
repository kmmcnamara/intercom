<?php

namespace Calendar\Services;

use Calendar\Domain\Event;
use PHPUnit\Framework\TestCase;

class EventLoaderTest extends TestCase
{
    const JSON = '{
        "events": [{
           "occasion": "Party",
           "invited_count": "20",
           "year": "2017",
           "month": "7",
           "day": "12"
        }]
    }';

    /** @var EventLoader */
    private $eventLoader;

    public function setUp()
    {
        $mockFileLoader = $this->getMockBuilder(FileLoader::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockFileLoader->method('loadFile')
            ->willReturn(self::JSON);

        $this->eventLoader = new EventLoader($mockFileLoader);
    }

    public function testLoadEvent()
    {
        $calendar = $this->eventLoader->loadEvents();

        /** @var Event $event */
        $events = $calendar->getAllEvents();
        $this->assertEquals(1, count($events));
        
        $event = current($events);
        $this->assertEquals('Party', $event->getOccasion());
        $this->assertEquals(20, $event->getInvitedCount());
        $this->assertEquals('07/12/2017', $event->getDate()->format('m/d/Y'));
    }

}