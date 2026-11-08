<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Shipment;
use App\Services\Delivery\ShippingService;

class ShipmentController extends Controller
{
    public function index()
    {
        $shipments = Shipment::with('order')->get();

        return response()->json($shipments);
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'force_provider' => 'nullable|in:internal,canadapost,ups',
            'priority' => 'nullable|boolean',
        ]);

        $order = Order::with('orderItems')->findOrFail($request->order_id);

        $shippingService = app(ShippingService::class);

        $shipment = $shippingService->createShipment(
            $order,
            $request->force_provider,
            $request->priority ?? false
        );

        return response()->json([
            'message' => 'Shipment created successfully',
            'shipment' => $shipment
        ], 201);
    }

    public function show(Shipment $shipment)
    {
        $shipment->load('order');

        return response()->json($shipment);
    }

    public function edit(Shipment $shipment)
    {
        return response()->json([
            'message' => 'Edit form is not used in API',
            'shipment' => $shipment
        ]);
    }

    public function update(Request $request, Shipment $shipment)
    {
        $request->validate([
            'provider' => 'required|string',
            'tracking_number' => 'required|string',
            'status' => 'required|string',
            'shipping_cost' => 'required|numeric',
            'currency' => 'required|string|max:3',
            'label' => 'nullable|string',
        ]);

        $shipment->update($request->all());

        return response()->json([
            'message' => 'Shipment updated successfully',
            'shipment' => $shipment
        ]);
    }

    public function destroy(Shipment $shipment)
    {
        $shipment->delete();

        return response()->json([
            'message' => 'Shipment deleted successfully'
        ]);
    }
}