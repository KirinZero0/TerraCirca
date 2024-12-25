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
        $products = ProductOut::whereHas('productList', function ($query) {
            $search = session()->get('search');
            $query->where('name', 'like', '%' . $search . '%');
        });

        if(session()->get('month')) {
            $products->whereMonth('date', session()->get('month'));
        }

        if(session()->get('type')) {
            $products->where('type', session()->get('type'));
        }

        if (session()->get('year')) {
            $products->whereYear('date', session()->get('year'));
        }

        return view('admin.pages.laporan.keluar.excel', [
            'products' => $products->orderby('id', 'DESC')->get()
        ]);
    }
}
