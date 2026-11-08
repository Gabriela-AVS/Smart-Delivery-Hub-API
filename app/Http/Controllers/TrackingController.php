<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Services\Delivery\ShippingService;

class TrackingController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Use /track/{shipment} to track a shipment'
        ]);
    }

    public function store()
    {
        return response()->json([
            'message' => 'Store is not used for tracking'
        ]);
    }

    public function show(Shipment $shipment)
    {
        $shippingService = app(ShippingService::class);

        $tracking = $shippingService->trackShipment($shipment);

        return response()->json($tracking);
    }

    public function edit(Shipment $shipment)
    {
        return response()->json([
            'message' => 'Edit form is not used in API',
            'shipment' => $shipment
        ]);
    }

    public function update()
    {
        return response()->json([
            'message' => 'Update is not used for tracking'
        ]);
    }

    public function destroy()
    {
        return response()->json([
            'message' => 'Destroy is not used for tracking'
        ]);
    }
}
