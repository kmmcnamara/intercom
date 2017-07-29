<?php

namespace Calendar\Domain;

use PHPUnit\Framework\TestCase;
use DateTime;

class CalendarTest extends TestCase {
    /** @var Calendar */
    private $calendar;
    /** @var Event */
    private $event1;
    /** @var Event */
    private $event2;

    public function setUp() {
        $this->event1 = new Event(
            'Party',
            40,
            DateTime::createFromFormat('m/d/Y', '7/7/2017')
        );
        $this->event2 = new Event(
            'Study',
            1,
            DateTime::createFromFormat('m/d/Y', '7/7/1997')
        );
        $this->calendar = new Calendar([$this->event1, $this->event2]);
    }

    public function testGetAllEvents() {
        $this->assertEquals([$this->event2, $this->event1], $this->calendar->getAllEvents());
    }

    public function testGetEventsAfterDate() {
        $event = $this->calendar->getEventsAfterDate(DateTime::createFromFormat('m/d/Y', '7/8/1997'))->getAllEvents();
        $this->assertEquals([$this->event1], $event);
    }

    public function testGetEventsBeforeDate() {
        $event = $this->calendar->getEventsBeforeDate(DateTime::createFromFormat('m/d/Y', '7/8/1997'))->getAllEvents();
        $this->assertEquals([$this->event2], $event);
    }

    public function testGetEventsWithAtLeastSoManyPeople() {
        $event = $this->calendar->getEventsWithAtLeastSoManyPeople(4)->getAllEvents();
        $this->assertEquals([$this->event1], $event);
    }

    public function testGetEventsWithAtMostSoManyPeople() {
        $event = $this->calendar->getEventsWithAtMostSoManyPeople(4)->getAllEvents();
        $this->assertEquals([$this->event2], $event);
    }
}