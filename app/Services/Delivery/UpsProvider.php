<?php

namespace App\Services\Delivery;

use App\Models\Order;

class UpsProvider extends DeliveryProvider implements Trackable
{
    public function quote(Order $order): Money
    {
        $weight = $order->orderItems->sum('weight');

        return Money::fromCAD(1200 + ((int) ($weight * 200)));
    }

    public function createShipment(Order $order): ShipmentData
    {
        $cost = $this->quote($order);

        return new ShipmentData(
            'UPS',
            'UPS-' . strtoupper(uniqid()),
            'created',
            $cost
        );
    }

    public function providerName(): string
    {
        return 'UPS';
    }

    public function track(string $trackingNumber): TrackingResult
    {
        return new TrackingResult(
            $trackingNumber,
            'delivered',
            'Shipment delivered successfully'
        );
    }
}