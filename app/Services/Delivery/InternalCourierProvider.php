<?php

namespace App\Services\Delivery;

use App\Models\Order;

class InternalCourierProvider extends DeliveryProvider
{
    public function quote(Order $order): Money
    {
        $base = 500;
        $itemCount = $order->orderItems->sum('quantity');

        return Money::fromCAD($base + ($itemCount * 100));
    }

    public function createShipment(Order $order): ShipmentData
    {
        $cost = $this->quote($order);

        return new ShipmentData(
            'Internal Courier',
            'INT-' . strtoupper(uniqid()),
            'created',
            $cost
        );
    }

    public function providerName(): string
    {
        return 'Internal Courier';
    }
}