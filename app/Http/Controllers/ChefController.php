<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Reservation;

class ChefController extends Controller
{
    public function index()
    {
        $reservations = Reservation::where('name', 'like', '%' . \request()->get('search') . '%')
        ->where('status', Reservation::PROGRESS) 
        ->orderBy('id', 'DESC')
        ->paginate(10);
        $menus = Menu::where('name', 'like', '%'.\request()->get('search').'%')->get();

        $orders = [];

        foreach ($reservations as $reservation) {
            $reservationOrders = Order::where('reservation_id', $reservation->id)
                ->get();
            $orders = array_merge($orders, $reservationOrders->all());

            $reservation->pendingOrderCount = Order::where('reservation_id', $reservation->id)
            ->where('status', Order::PENDING)
            ->sum('quantity');
        }

        return view('admin.pages.chef.index', compact('reservations', 'menus', 'orders'));
    }

    public function cancel(Order $order)
    {
        $order->status = Order::PENDING;
        $order->save();

        return redirect()->back()->with('success', 'Order Canceled');
    }

    public function done(Order $order)
    {
        $order->status = Order::DONE;
        $order->save();

        return redirect()->back()->with('success', 'Order Done');
    }

}
