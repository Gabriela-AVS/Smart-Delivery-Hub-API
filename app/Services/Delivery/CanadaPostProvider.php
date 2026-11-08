<?php

namespace App\Services\Delivery;

use App\Models\Order;

class CanadaPostProvider extends DeliveryProvider implements Trackable
{
    public function quote(Order $order): Money
    {
        $weight = $order->orderItems->sum('weight');

        return Money::fromCAD(800 + ((int) ($weight * 150)));
    }

    public function createShipment(Order $order): ShipmentData
    {
        $cost = $this->quote($order);

        return new ShipmentData(
            'Canada Post',
            'CP-' . strtoupper(uniqid()),
            'created',
            $cost
        );
    }

    public function providerName(): string
    {
        return 'Canada Post';
    }

    public function track(string $trackingNumber): TrackingResult
    {
        return new TrackingResult(
            $trackingNumber,
            'in_transit',
            'Shipment is moving through the network'
        );
    }
}