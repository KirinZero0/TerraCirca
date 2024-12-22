<?php

namespace App\Http\Controllers;

use App\Exports\LaporanBarangKeluar;
use App\Models\ProductOut;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanKeluarController extends Controller
{
    public function index()
    {
        $months = [];
        $products = ProductOut::whereHas('productList', function ($query) {
            $search = request()->get('search');
            $query->where('name', 'like', '%' . $search . '%');
        });

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

        return view('admin.pages.laporan.keluar.index', [
            'products' => $products->orderby('date', 'DESC')->paginate(10),
            'months' => $months
        ]);
    }

    public function export()
    {
        return Excel::download(new LaporanBarangKeluar(), now()->format('Y-m-d').'-laporan-barang-keluar.xlsx');
    }
}
