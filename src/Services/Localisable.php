<?php

namespace App\Services;
interface Localisable
{
    public function getLatitude(): ?float;
    public function getLongitude(): ?float;
}