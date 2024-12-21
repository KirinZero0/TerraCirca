<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\ProductIn;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanBarangMasuk implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        $products = ProductIn::whereHas('productList', function ($query) {
            $search = session()->get('search');
            $query->where('name', 'like', '%' . $search . '%');
        });

        if(session()->get('month')) {
            $products->whereMonth('date', session()->get('month'));
        }

        return view('admin.pages.laporan.masuk.excel', [
            'products' => $products->orderby('id', 'DESC')->get()
        ]);
    }
}
