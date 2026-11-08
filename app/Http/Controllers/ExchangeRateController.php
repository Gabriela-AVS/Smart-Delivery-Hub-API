<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\External\ExchangeRateService;

class ExchangeRateController extends Controller
{
    public function convert(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0'
        ]);

        $exchangeRateService = app(ExchangeRateService::class);

        $usdAmount = $exchangeRateService->convertCadToUsd($request->amount);

        if ($usdAmount === null) {
            return response()->json([
                'message' => 'Could not fetch exchange rate'
            ], 500);
        }

        return response()->json([
            'cad_amount' => $request->amount,
            'usd_amount' => $usdAmount
        ]);
    }
}
