<?php

require __DIR__ . '/vendor/autoload.php';

use Drinks\Services\CustomerLoader;
use Drinks\Domain\Customer;
use Drinks\Services\DistanceChecker;
use Drinks\Domain\Location;

$customerLoader = new CustomerLoader();

$customers = $customerLoader->loadCustomers();
$distanceToHQ = 100; //in km

$closeCustomers = [];
$distanceChecker = new DistanceChecker();
$hqLocation = new Location(53.3381985, -6.2592576);

/** @var Customer $customer */
foreach ($customers as $customer) {
    if ($distanceChecker->areLocationsClose($customer->getLocation(), $hqLocation, $distanceToHQ)) {
        $closeCustomers[] = $customer;
    }
}

usort($closeCustomers, function($a, $b) {
    /** @var Customer $a */
    /** @var Customer $b */
    return $a->getUserId() > $b->getUserId();
});

foreach ($closeCustomers as $customer) {
    echo "User ID: {$customer->getUserId()} - Name: {$customer->getName()}\n";
}