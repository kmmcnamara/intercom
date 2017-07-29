<?php

namespace Calendar\Domain;

use DateTime;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use TypeError;

class EventTest extends TestCase {
    /** @var Event */
    private $event;

    private $occasion;
    private $invitedCount;
    private $date;

    public function setUp() {
        $this->occasion = 'Party!';
        $this->invitedCount = 400;
        $this->date = DateTime::createFromFormat('m/d/Y', '7/7/2017');
    }

    public function testEventCreation() {
        $event = new Event(
            $this->occasion,
            $this->invitedCount,
            $this->date
        );
        $this->assertEquals($this->occasion, $event->getOccasion());
        $this->assertEquals($this->invitedCount, $event->getInvitedCount());
        $this->assertEquals($this->date, $event->getDate());
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Occasion must be of type string
     */
    public function testBadOccasion() {
        $event = new Event(
            5,
            $this->invitedCount,
            $this->date
        );
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invited Count must be of type int
     */
    public function testBadTitle() {
        $event = new Event(
            $this->occasion,
            'hi',
            $this->date
        );
    }

    /**
     * @expectedException TypeError
     */
    public function testBadDate() {
        $event = new Event(
            $this->occasion,
            $this->invitedCount,
            5
        );
    }
}