<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::where('name', 'like', '%'.\request()->get('search').'%')->orderby('id', 'DESC')->paginate(10);
        return view('admin.pages.reservation.index', compact('reservations'));
    }

    public function create(){
        return view('admin.pages.reservation.create');
    }

    public function serve(Reservation $reservation){

        $reservation->status = Reservation::PROGRESS;
        $reservation->save();

        $menus = Menu::where('name', 'like', '%'.\request()->get('search').'%')->get();
        $orders = Order::where('reservation_id', $reservation->id)->get();
        return view('admin.pages.reservation.serve', compact('menus', 'reservation', 'orders'));
    }


    public function store(Request $request)
    {

        $submitType = $_POST['submit_type']; 

        if ($submitType == 'save') {
            $reservation = new Reservation();
            $reservation->fill([
                'reference_id' => $request->reference_id,
                'table_number' => $request->table_number,
                'name' => $request->name,
                'number_of_people' => $request->number_of_people,
                'date' => $request->date,
                'status' => Reservation::PENDING,
            ]);
            $reservation->saveOrFail();

            $table_number = $reservation->table_number;
            $table = Table::where('table_number', $table_number)->first();
            
            if($table){
                $table->status = Table::UNAVAILABLE; 
                $table->save();
            }

            return redirect(route('admin.reservation.index'));

        } elseif ($submitType == 'serve') {
            $reservation = new Reservation();
            $reservation->fill([
                'reference_id' => $request->reference_id,
                'table_number' => $request->table_number,
                'name' => $request->name,
                'number_of_people' => $request->number_of_people,
                'date' => $request->date,
                'status' => Reservation::PROGRESS,
            ]);
            $reservation->saveOrFail();

            $table_number = $reservation->table_number;
            $table = Table::where('table_number', $table_number)->first();
            
            if($table){
                $table->status = Table::UNAVAILABLE; 
                $table->save();
            }

            $menus = Menu::where('name', 'like', '%'.\request()->get('search').'%')->get();
            $orders = Order::where('reservation_id', $reservation->id)->get();

            return redirect()->route('admin.reservation.serve', compact('reservation', 'menus', 'orders'));
        }
    }

    public function view(Reservation $reservation)
    {
        $menus = Menu::where('name', 'like', '%'.\request()->get('search').'%')->get();
        $orders = Order::where('reservation_id', $reservation->id)->get();
        return view('admin.pages.reservation.view', compact('reservation', 'orders', 'menus'));
    }

    public function cancel(Reservation $reservation)
    {
        $reservation->status = Reservation::CANCEL;
        $reservation->save();

        $reservation->orders()->delete();

        $table_number = $reservation->table_number;
        $table = Table::where('table_number', $table_number)->first();

        if($table){
            $table->status = Table::AVAILABLE; 
            $table->save();
        }

        return redirect()->back()->with('success', 'Reservation Canceled');
    }

    public function finish(Reservation $reservation)
    {
        $table_number = $reservation->table_number;
        $table = Table::where('table_number', $table_number)->first();

        if($table){
            $table->status = Table::AVAILABLE; 
            $table->save();
        }

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
