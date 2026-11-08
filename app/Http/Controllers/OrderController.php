<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\Delivery\ShippingService;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['customer', 'orderItems', 'shipment'])->get();

        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'delivery_type' => 'required|in:internal,canadapost,ups',
            'total_amount' => 'required|numeric',
            'currency' => 'required|string|max:3',
        ]);

        $order = Order::query()->create($request->all());

        return response()->json([
            'message' => 'Order created successfully',
            'order' => $order
        ], 201);
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'orderItems', 'shipment']);

        return response()->json($order);
    }

    public function edit(Order $order)
    {
        return response()->json([
            'message' => 'Edit form is not used in API',
            'order' => $order
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'delivery_type' => 'required|in:internal,canadapost,ups',
            'status' => 'required|string',
            'total_amount' => 'required|numeric',
            'currency' => 'required|string|max:3',
        ]);

        $order->update($request->all());

        return response()->json([
            'message' => 'Order updated successfully',
            'order' => $order
        ]);
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json([
            'message' => 'Order deleted successfully'
        ]);
    }
}
