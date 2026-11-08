<?php

namespace App\Services\Delivery;

class ShipmentData
{
    public string $provider;
    public string $trackingNumber;
    public string $status;
    public Money $cost;

    public function __construct(string $provider, string $trackingNumber, string $status, Money $cost)
    {
        $this->provider = $provider;
        $this->trackingNumber = $trackingNumber;
        $this->status = $status;
        $this->cost = $cost;
    }
}