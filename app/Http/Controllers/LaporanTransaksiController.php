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

        $month = 1;
        do {
            $months[] = date('F', mktime(0,0,0, $month, 1, date('Y')));
            $month++;
        } while($month <= 12);

        session()->put('month', \request()->get('month'));
        session()->put('status', \request()->get('status'));

        return view('admin.pages.laporan.transaksi.index', [
            'transactions' => $transactions->orderby('date', 'DESC')->paginate(10),
            'months' => $months
        ]);
    }

    public function export()
    {
        return Excel::download(new LaporanTransaksi(), now()->format('Y-m-d').'-laporan-transaksi.xlsx');
    }
}
