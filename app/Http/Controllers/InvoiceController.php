<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Reservation;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function generate(Reservation $reservation)
    {

        $orders = Order::where('reservation_id', $reservation->id)->get();
        $html = view('admin.pages.reservation.invoices.index', compact('reservation', 'orders'))->render();

        $pdf = new \Mpdf\Mpdf();

        $pdf->WriteHTML($html);

        $pdf->Output('INVOICE-'.$reservation->reference_id.'-'.$reservation->date->format('F j, Y - H:i').'.pdf', 'I');
    }
}
