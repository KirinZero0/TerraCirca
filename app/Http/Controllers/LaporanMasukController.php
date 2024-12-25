<?php

namespace App\Http\Controllers;

use App\Exports\LaporanBarangMasuk;
use App\Models\Product;
use App\Models\ProductIn;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanMasukController extends Controller
{
    public function index()
    {
        $months = [];
        $products = ProductIn::whereHas('productList', function ($query) {
            $search = request()->get('search');
            $query->where('name', 'like', '%' . $search . '%');
        });

        if(\request()->get('month')) {
            $products->whereMonth('date', \request()->get('month'));
        }

        if (\request()->get('year')) {
            $products->whereYear('date', \request()->get('year'));
        }

        $month = 1;
        do {
            $months[] = date('F', mktime(0,0,0, $month, 1, date('Y')));
            $month++;
        } while($month <= 12);

        $years = ProductIn::selectRaw('YEAR(date) as year')
        ->distinct()
        ->orderBy('year', 'DESC')
        ->pluck('year');

        session()->put('month', \request()->get('month'));
        session()->put('year', \request()->get('year'));

        return view('admin.pages.laporan.masuk.index', [
            'products' => $products->orderby('date', 'DESC')->paginate(10),
            'months' => $months,
            'years' => $years,
        ]);
    }

    public function export()
    {
        return Excel::download(new LaporanBarangMasuk(), now()->format('Y-m-d').'-laporan-barang-masuk.xlsx');
    }
}
