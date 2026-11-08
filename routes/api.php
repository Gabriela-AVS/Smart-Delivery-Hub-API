<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\ExchangeRateController;

Route::apiResource('customers', CustomerController::class);
Route::apiResource('orders', OrderController::class);
Route::apiResource('shipments', ShipmentController::class);
Route::apiResource('track', TrackingController::class)->parameters([
    'track' => 'shipment'
]);
Route::get('exchange-rate', [ExchangeRateController::class, 'convert']);
