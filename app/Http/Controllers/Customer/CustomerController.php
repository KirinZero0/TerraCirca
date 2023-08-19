<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function customerOrder($refid) 
    {
        $reservation = Reservation::where('reference_id', $refid)->firstOrFail();
        $menus = Menu::where('name', 'like', '%'.\request()->get('search').'%')->get();
        $orders = Order::where('reservation_id', $reservation->id)->get();
        $totalQuantity = Order::where('reservation_id', $reservation->id)->sum('quantity');
        return view('customer.order2', compact('reservation', 'totalQuantity', 'menus', 'orders'));
    }

    public function customerRegis($qr) 
    {
        $table = Table::where('reference_id', $qr)->first();
        return view('customer.order1', compact('table'));
    }

    public function customerFinish($refid)
    {
        $reservation = Reservation::where('reference_id', $refid)->firstOrFail();
        $orders = Order::where('reservation_id', $reservation->id)->get();
        $reservation->status = Reservation::PROGRESS;
        $reservation->save();

        return view('customer.finish', compact('reservation', 'orders'));
    }

    public function store(Request $request){

        $reservation = new Reservation();
            $reservation->fill([
                'reference_id' => "RSV" . rand(100000, 999999),
                'table_number' => $request->table_number,
                'name' => $request->name,
                'number_of_people' => $request->number_of_people,
                'date' => now(),
                'status' => Reservation::ORDER,
            ]);
            $reservation->saveOrFail();

            return redirect()->route('customer.order', ['refid' => $reservation->reference_id]);
    }

    public function addOrder(Request $request)
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
