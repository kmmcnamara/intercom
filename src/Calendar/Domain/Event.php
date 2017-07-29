<?php

namespace Calendar\Domain;

use DateTime;
use InvalidArgumentException;

class Event {

    /** @var string */
    private $occasion;

    /** @var int */
    private $invitedCount;

    /** @var DateTime */
    private $date;

    /**
     * @param string $occasion
     * @param int $invitedCount
     * @param DateTime $date
     * @throws InvalidArgumentException
     */
    public function __construct($occasion, $invitedCount, DateTime $date) {
        if (!is_string($occasion)) {
            throw new InvalidArgumentException('Occasion must be of type string');
        }
        if (!is_int($invitedCount)) {
            throw new InvalidArgumentException('Invited Count must be of type int');
        }
        //If $date isn't a DateTime that will catch on its own
        $this->occasion = $occasion;
        $this->invitedCount = $invitedCount;
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getOccasion() {
        return $this->occasion;
    }

    /**
     * @return int
     */
    public function getInvitedCount() {
        return $this->invitedCount;
    }

    /**
     * @return DateTime
     */
    public function getDate() {
        return $this->date;
    }
}