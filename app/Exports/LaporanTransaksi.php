<?php

namespace App\Exports;

use App\Enums\TransactionStatusEnum;
use App\Models\Product;
use App\Models\Reservation;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanTransaksi implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        $transactions = Transaction::where('reference_id', 'like', '%'.\request()->get('search').'%')->where('status', TransactionStatusEnum::FINISHED);

        if(session()->get('month')) {
            $transactions->whereMonth('date', session()->get('month'));
        }

        if (session()->get('year')) {
            $transactions->whereYear('date', session()->get('year'));
        }

        return view('admin.pages.laporan.transaksi.excel', [
            'transactions' =>  $transactions->orderby('id', 'DESC')->get()
        ]);
    }
}
