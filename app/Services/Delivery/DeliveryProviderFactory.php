<?php

namespace App\Services\Delivery;

use InvalidArgumentException;

class DeliveryProviderFactory
{
    private array $map = [
        'internal' => InternalCourierProvider::class,
        'canadapost' => CanadaPostProvider::class,
        'ups' => UpsProvider::class,
    ];

    public function make(string $type): DeliveryProvider
    {
        if (!isset($this->map[$type])) {
            throw new InvalidArgumentException("Unknown provider: {$type}");
        }

        $class = $this->map[$type];

        return app($class);
    }
}