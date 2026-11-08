<?php

namespace App\Services\External;

use App\Models\ApiLog;
use Illuminate\Support\Facades\Http;

class ExchangeRateService
{
    public function convertCadToUsd(float $amount): ?float
    {
        $url = 'https://open.er-api.com/v6/latest/CAD';

        $response = Http::get($url);

        ApiLog::query()->create([
            'service_name' => 'ExchangeRateAPI',
            'endpoint' => $url,
            'request_payload' => json_encode([
                'base' => 'CAD',
                'target' => 'USD',
                'amount' => $amount,
            ]),
            'response_payload' => $response->body(),
            'status_code' => $response->status(),
        ]);

        if ($response->successful()) {
            $rate = $response->json('rates.USD');

            if ($rate) {
                return $rate * $amount;
            }
        }

        return null;
    }
}