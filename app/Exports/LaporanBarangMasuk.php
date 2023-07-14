<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanBarangMasuk implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        $products = Product::where('code', 'like', '%'.session()->get('search').'%');

        if(session()->get('month')) {
            $products->whereMonth('date', session()->get('month'));
        }

        if($status = session()->get('status')) {
            $products->where('status', $status);
        }

        return view('admin.pages.laporan.masuk.excel', [
            'products' => $products->orderby('id', 'DESC')->get()
        ]);
    }
}
