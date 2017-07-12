<?php

namespace Drinks\Domain;

class Customer {

    private $userId;
    private $name;

    /** @var Location */
    private $location;

    public function __construct($userId, $name, Location $location) {
        $this->userId = $userId;
        $this->name = $name;
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Location
     */
    public function getLocation()
    {
        return $this->location;
    }
}