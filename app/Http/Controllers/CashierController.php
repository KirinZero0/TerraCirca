<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Reservation;

class CashierController extends Controller
{
    public function index()
    {
        $reservations = Reservation::where('name', 'like', '%' . \request()->get('search') . '%')
        ->where('status', Reservation::PROGRESS) 
        ->orderBy('id', 'DESC')
        ->paginate(10);
        
        return view('admin.pages.cashier.index', compact('reservations'));
    }


    public function cancel(Reservation $reservation)
    {
        $reservation->status = Reservation::CANCEL;
        $reservation->save();

        $reservation->orders()->delete();

        return redirect()->back()->with('success', 'Reservation Canceled');
    }

    public function finish(Reservation $reservation)
    {
        $reservation->status = Reservation::FINISH;
        $reservation->save();

        return redirect()->back()->with('success', 'Reservation Finished');
    }

    public function destroy(Reservation $reservation)
    {
        Order::where('reservation_id', $reservation->id)->delete();
        
        $reservation->delete();

        return redirect(route('admin.reservation.index'));
    }
}
