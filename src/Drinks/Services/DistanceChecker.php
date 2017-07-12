<?php

namespace Drinks\Services;

use Drinks\Domain\Location;

class DistanceChecker {

    const MEAN_RADIUS_OF_EARTH = 6371; //in km

    public function areLocationsClose(Location $location1, Location $location2, $distance) {
        $lat1rad = deg2rad($location1->getLatitude());
        $lat2rad = deg2rad($location2->getLatitude());

        $long1rad = deg2rad($location1->getLongitude());
        $long2rad = deg2rad($location2->getLongitude());

        $centralAngle = acos((sin($lat1rad) * sin($lat2rad)) + (cos($lat1rad) * cos($lat2rad) * cos(abs($long2rad - $long1rad))));
        $arcDistance = self::MEAN_RADIUS_OF_EARTH * $centralAngle;

        return $arcDistance < $distance;
    }

}