<?php

namespace App\Services;

use App\Services\Localisable;

class DistanceCalculator
{
    public const EARTH_RADIUS = 6378.137;

    public function getDistance(Localisable $from, Localisable $to)
    {
        $rlo1 = deg2rad($from->getLongitude());
        $rla1 = deg2rad($from->getLatitude());
        $rlo2 = deg2rad($to->getLongitude());
        $rla2 = deg2rad($to->getLatitude());
        $dlo = ($rlo2 - $rlo1) / 2;
        $dla = ($rla2 - $rla1) / 2;
        $a = (sin($dla) * sin($dla)) + cos($rla1) * cos($rla2) * (sin($dlo) * sin($dlo));
        $d = 2 * atan2(sqrt($a), sqrt(1 - $a));
        
        return (self::EARTH_RADIUS * $d);
    }
}