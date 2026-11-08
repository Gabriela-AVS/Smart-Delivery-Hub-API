<?php

namespace App\Services\Delivery;

class Money
{
    public int $cents;
    public string $currency;

    public function __construct(int $cents, string $currency = 'CAD')
    {
        $this->cents = $cents;
        $this->currency = $currency;
    }

    public static function fromCAD(int $cents): self
    {
        return new self($cents, 'CAD');
    }

    public static function fromFloat(float $amount, string $currency): self
    {
        return new self((int) round($amount * 100), $currency);
    }

    public function formatted(): string
    {
        return number_format($this->cents / 100, 2) . ' ' . $this->currency;
    }
}