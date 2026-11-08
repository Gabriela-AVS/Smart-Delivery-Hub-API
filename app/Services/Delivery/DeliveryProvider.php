<?php

namespace App\Services\Delivery;

use App\Models\Order;

abstract class DeliveryProvider
{
    abstract public function quote(Order $order): Money;

    abstract public function createShipment(Order $order): ShipmentData;

    public function providerName(): string
    {
        return 'Generic Provider';
    }

    public function formatLabel(ShipmentData $data): string
    {
        return "Provider: {$data->provider}\nTracking Number: {$data->trackingNumber}\nStatus: {$data->status}";
    }
}