<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Reservation;
use App\Models\Transaction;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    // public function generate(Reservation $reservation)
    // {

    //     $orders = Order::where('reservation_id', $reservation->id)->get();
    //     $html = view('admin.pages.reservation.invoices.index', compact('reservation', 'orders'))->render();

    //     $pdf = new \Mpdf\Mpdf();

    //     $pdf->WriteHTML($html);

    //     $pdf->Output('INVOICE-'.$reservation->reference_id.'-'.$reservation->date->format('F j, Y - H:i').'.pdf', 'I');
    // }

    public function generate2(Transaction $transaction, Request $request) //USE THIS
    {

        $items = $transaction->transactionItems;

        $html = view('admin.pages.invoice.index', compact('transaction', 'items'))->render();

        $pdf = new \Mpdf\Mpdf();

        $pdf->WriteHTML($html);

        $pdf->Output('INVOICE-'.$transaction->reference_id.'-'.$transaction->date->format('F j, Y - H:i').'.pdf', 'I');
    }

    // public function generate3(Reservation $reservation, Request $request)
    // {
    //     $html = view('customer.reservation.invoice', compact('reservation'))->render();

    //     $pdf = new \Mpdf\Mpdf();

    //     $pdf->WriteHTML($html);

    //     $pdf->Output('INVOICE-'.$reservation->reference_id.'.pdf', 'I');
    // }
}
