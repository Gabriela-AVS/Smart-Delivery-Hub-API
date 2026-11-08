<?php

namespace App\Services\Delivery;

class TrackingResult
{
    public string $trackingNumber;
    public string $status;
    public string $message;

    public function __construct(string $trackingNumber, string $status, string $message)
    {
        $this->trackingNumber = $trackingNumber;
        $this->status = $status;
        $this->message = $message;
    }
}