<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Reservation;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

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

    public function generate(Transaction $transaction, Request $request)
    {
        try {
            $connector = new WindowsPrintConnector('POS 58');
            $printer = new Printer($connector);
    
            // Transaction Details
            $transactionId = $transaction->reference_id;
            $transactionDate = $transaction->created_at->format('d-m-Y H:i:s');
            $items = $transaction->transactionItems;
            $total = $transaction->total;
            $cashier = $request->user()->username;
            $date = $transaction->created_at->format('d-m-y');
            $time = $transaction->created_at->format('h:i:s A');
            $patient = $transaction->patient->name ?? '-';
    
            // Print Header
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("APOTEK TERRA CIRCA\n");
            $printer->text("TAMAN GRIYA\n");
            $printer->text("(0361) 4724438\n");
            $printer->text(sprintf("No: %-15s %s\n", $transactionId, $date));
            $printer->text(sprintf("Kasir: %-12s %s\n", $cashier, $time));
            $printer->text("-----------------------------\n");
            $printer->text("Pasien-\n");
            $printer->text("$patient\n");

            foreach ($items as $item) {
                $printer->text(strtoupper($item->productStock->name) . "\n");
            
                $line = sprintf(
                    "%-3d x %15s %10s\n",
                    $item->quantity,                                     
                    formatRupiah($item->productStock->selling_price),
                    formatRupiah($item->total_amount)
                );
                $printer->text($line);
            }
            $printer->text("-----------------------------\n");
    
            // Print Total
            $printer->setEmphasis(true);
            $printer->text(sprintf("%20s %15s\n", "TOTAL", formatRupiah($transaction->total_amount)));
            $printer->setEmphasis(false);
            
            $printer->text(sprintf("%20s %15s\n", "BAYAR", formatRupiah($transaction->paid_amount))); // Replace $payment with the actual variable
            
            $printer->text(sprintf("%20s %15s\n", "KEMBALI", formatRupiah($transaction->change_amount))); 
    
            // Footer
            $printer->feed(2);
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("Terima kasih atas kunjungan Anda!\n");
            $printer->text("Semoga lekas sembuh dan sehat selalu.\n");
    
            // Cut Paper
            $printer->cut();
            $printer->close();
        } catch (Exception $e) {
            return response()->json(['error' => "Couldn't print receipt: " . $e->getMessage()]);
        }
    }

    // public function generate3(Reservation $reservation, Request $request)
    // {
    //     $html = view('customer.reservation.invoice', compact('reservation'))->render();

    //     $pdf = new \Mpdf\Mpdf();

    //     $pdf->WriteHTML($html);

    //     $pdf->Output('INVOICE-'.$reservation->reference_id.'.pdf', 'I');
    // }
}
