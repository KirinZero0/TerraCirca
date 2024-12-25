<?php

namespace App\Http\Controllers;

use App\Enums\TransactionStatusEnum;
use App\Exports\LaporanBarangMasuk;
use App\Exports\LaporanTransaksi;
use App\Models\Reservation;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanTransaksiController extends Controller
{
    public function index()
    {
        $months = [];
        $transactions = Transaction::where('reference_id', 'like', '%'.\request()->get('search').'%')->where('status', TransactionStatusEnum::FINISHED);

        if(\request()->get('month')) {
            $transactions->whereMonth('date', \request()->get('month'));
        }

           // Apply year filter if provided
        if (\request()->get('year')) {
            $transactions->whereYear('date', \request()->get('year'));
        }

        $month = 1;
        do {
            $months[] = date('F', mktime(0,0,0, $month, 1, date('Y')));
            $month++;
        } while($month <= 12);

        $years = Transaction::selectRaw('YEAR(date) as year')
        ->distinct()
        ->orderBy('year', 'DESC')
        ->pluck('year');

        session()->put('month', \request()->get('month'));
        session()->put('year', \request()->get('year'));

        return view('admin.pages.laporan.transaksi.index', [
            'transactions' => $transactions->orderby('date', 'DESC')->paginate(10),
            'months' => $months,
            'years' => $years,
        ]);
    }

    public function export()
    {
        return Excel::download(new LaporanTransaksi(), now()->format('Y-m-d').'-laporan-transaksi.xlsx');
    }
}
