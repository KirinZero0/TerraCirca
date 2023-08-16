<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $order = Order::firstOrCreate(
            [
                'reservation_id' => $request->reservation_id,
                'menu_id' => $request->menu_id,
                'status' => Order::PENDING
            ],
            [
                'quantity' => $request->quantity,
            ]
        );
    
        if (!$order->wasRecentlyCreated) {
            $order->quantity += $request->quantity;
            $order->save();
        }
        return redirect()->back()->with('success', 'Order added successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->back()->with('success', 'Order deleted successfully.');
    }
}
