<?php

namespace App\Services\Delivery;

use App\Models\Order;
use App\Models\Shipment;

class ShippingService
{
    protected DeliveryProviderFactory $factory;

    public function __construct(DeliveryProviderFactory $factory)
    {
        $this->factory = $factory;
    }

    public function createShipment(Order $order, ?string $forceProvider = null, bool $priority = false): Shipment
    {
        $providerKey = $forceProvider ?? $order->delivery_type;

        $provider = $this->factory->make($providerKey);

        $shipmentData = $provider->createShipment($order);

        if ($priority) {
            $shipmentData->status = 'priority_created';
        }

        return Shipment::query()->create([
            'order_id' => $order->id,
            'provider' => $shipmentData->provider,
            'tracking_number' => $shipmentData->trackingNumber,
            'status' => $shipmentData->status,
            'shipping_cost' => $shipmentData->cost->cents / 100,
            'currency' => $shipmentData->cost->currency,
            'label' => $provider->formatLabel($shipmentData),
        ]);
    }

    public function quote(Order $order, ?string $forceProvider = null): Money
    {
        $providerKey = $forceProvider ?? $order->delivery_type;

        $provider = $this->factory->make($providerKey);

        return $provider->quote($order);
    }

    public function trackShipment(Shipment $shipment): TrackingResult
    {
        $map = [
            'Internal Courier' => 'internal',
            'Canada Post' => 'canadapost',
            'UPS' => 'ups',
                ];

$providerKey = $map[$shipment->provider] ?? null;

        $provider = $this->factory->make($providerKey);

        if (!$provider instanceof Trackable) {
            return new TrackingResult(
                $shipment->tracking_number,
                $shipment->status,
                'Tracking not supported for this provider'
            );
        }

        return $provider->track($shipment->tracking_number);
    }
}