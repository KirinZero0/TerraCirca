<?php

namespace App\Http\Controllers;

use App\Models\ProductStock;
use Illuminate\Http\Request;

class StokBarangController extends Controller
{
    public function index()
    {
        $products = ProductStock::where(function ($query) {
            $search = \request()->get('search');
            $query->where('name', 'like', '%' . $search . '%');
        })
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('admin.pages.barang.stok.index', [
            'products' => $products
        ]);
    }
}
