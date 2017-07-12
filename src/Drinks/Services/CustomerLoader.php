<?php

namespace Drinks\Services;


use Drinks\Domain\Customer;
use Drinks\Domain\Location;

class CustomerLoader
{
    const FILE_LOCATION =  __DIR__ . "/../Data/customers.txt";

    const USER_ID   = 'user_id';
    const NAME      = 'name';
    const LATITUDE  = 'latitude';
    const LONGITUDE = 'longitude';

    private $fileHandler;

    public function __construct(FileHandler $fileHandler = null)
    {
        if (!$fileHandler instanceof FileHandler) {
            $fileHandler = new FileHandler(self::FILE_LOCATION);
        }
        $this->fileHandler = $fileHandler;
    }

    /**
     * @return array
     */
    public function loadCustomers()
    {
        $fileHandler = $this->getFileHandler();

        $loadedCustomers = [];
        while ($line = $fileHandler->getNextLine()) {
            $customersJson = json_decode($line, true);
            //print_r($customersJson);

            $userId = (int)$customersJson[self::USER_ID];
            $name = $customersJson[self::NAME];
            $latitude = (float)$customersJson[self::LATITUDE];
            $longitude = (float)$customersJson[self::LONGITUDE];

            $location = new Location($latitude, $longitude);
            $loadedCustomers[] = new Customer($userId, $name, $location);
        }

        $fileHandler->closeFile();
        return $loadedCustomers;
    }

    /**
     * @return FileHandler
     */
    public function getFileHandler()
    {
        return $this->fileHandler;
    }
}