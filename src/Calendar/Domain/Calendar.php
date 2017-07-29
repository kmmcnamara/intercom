<?php

namespace Calendar\Domain;

use DateTime;
use InvalidArgumentException;

class Calendar {

    /** @var array */
    private $events;

    public function __construct(array $events) {
        $this->events = $events;
    }

    /**
     * @return array
     */
    public function getAllEvents() {
        $events = $this->events;

        usort($events, function ($a, $b) {
            /** @var Event $a */
            /** @var Event $b */
            return $a->getDate() > $b->getDate();
        });

        return $events;
    }

    /**
     * @param DateTime $date
     * @return Calendar
     */
    public function getEventsBeforeDate(DateTime $date) {
        $events = [];

        /** @var Event $event */
        foreach ($this->events as $event) {
            if ($event->getDate() < $date) {
                $events[] = $event;
            }
        }

        return new self($events);
    }

    /**
     * @param DateTime $date
     * @return Calendar
     */
    public function getEventsAfterDate(DateTime $date) {
        $events = [];

        /** @var Event $event */
        foreach ($this->events as $event) {
            if ($event->getDate() > $date) {
                $events[] = $event;
            }
        }

        return new self($events);
    }

    /**
     * @param int $inviteLimit
     * @return Calendar
     */
    public function getEventsWithAtLeastSoManyPeople($inviteLimit) {
        if (!is_numeric($inviteLimit)) {
            throw new InvalidArgumentException('You can only search for events using numbers');
        }

        $events = [];

        /** @var Event $event */
        foreach ($this->events as $event) {
            if ($event->getInvitedCount() >= $inviteLimit) {
                $events[] = $event;
            }
        }

        return new self($events);
    }

    /**
     * @param $inviteLimit
     * @return Calendar
     */
    public function getEventsWithAtMostSoManyPeople($inviteLimit) {
        if (!is_numeric($inviteLimit)) {
            throw new InvalidArgumentException('You can only search for events using numbers');
        }

        $events = [];

        /** @var Event $event */
        foreach ($this->events as $event) {
            if ($event->getInvitedCount() <= $inviteLimit) {
                $events[] = $event;
            }
        }

        return new self($events);
    }

}