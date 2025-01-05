<?php
/*
 * author Arya Permana - Kirin
 * created on 05-01-2025-12h-45m
 * github: https://github.com/KirinZero0
 * copyright 2025
*/


namespace App\Exports;

use App\Enums\TransactionStatusEnum;
use App\Models\Product;
use App\Models\Reservation;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanTransaksiToday implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        $transactionItems = TransactionItem::whereHas('transaction', function ($query) {
            $query->whereDate('date', today()) // Filter by today's date on the transaction model
                  ->where('status', TransactionStatusEnum::FINISHED); // Ensure the status is 'FINISHED' on the transaction
        });

        return view('admin.pages.transaction.excel', [
            'transactions' =>  $transactionItems->orderby('id', 'DESC')->get()
        ]);
    }
}
