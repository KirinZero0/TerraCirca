<?php

namespace App\Exports;

use App\Models\ProductOut;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanBarangKeluar implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        $products = ProductOut::where('code', 'like', '%'.session()->get('search').'%');

        if(session()->get('month')) {
            $products->whereMonth('date', session()->get('month'));
        }

        if($type = session()->get('type')) {
            $products->where('type', $type);
        }

        return view('admin.pages.laporan.keluar.excel', [
            'products' => $products->orderby('id', 'DESC')->get()
        ]);
    }
}
