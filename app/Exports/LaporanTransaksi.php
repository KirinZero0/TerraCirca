<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\Reservation;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanTransaksi implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        $reservations = Reservation::where('name', 'like', '%'.\request()->get('search').'%')->where('status', Reservation::FINISH);

        if(session()->get('month')) {
            $reservations->whereMonth('date', session()->get('month'));
        }

        return view('admin.pages.laporan.transaksi.excel', [
            'reservations' =>  $reservations->orderby('id', 'DESC')->get()
        ]);
    }
}
