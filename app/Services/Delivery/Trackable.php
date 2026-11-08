<?php

namespace App\Services\Delivery;

interface Trackable
{
    public function track(string $trackingNumber): TrackingResult;
}