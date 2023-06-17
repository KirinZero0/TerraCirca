<?php

namespace App\Http\Controllers;

use App\Exports\LaporanBarangExport;
use App\Models\Product;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanBarangController extends Controller
{
    public function index()
    {
        $months = [];
        $products = Product::where('code', 'like', '%'.\request()->get('search').'%');

        if(\request()->get('month')) {
            $products->whereMonth('date', \request()->get('month'));
        }

        if($type = request()->get('type')) {
            $products->where('type', $type);
        }

        $month = 1;
        do {
            $months[] = date('F', mktime(0,0,0, $month, 1, date('Y')));
            $month++;
        } while($month <= 12);

        session()->put('month', \request()->get('month'));
        session()->put('type', \request()->get('type'));

        return view('admin.pages.barang.laporan.index', [
            'products' => $products->orderby('id', 'DESC')->paginate(10),
            'months' => $months
        ]);
    }

    public function export()
    {
        return Excel::download(new LaporanBarangExport(), now()->format('Y-m-d').'-laporan-barang.xlsx');
    }
}
