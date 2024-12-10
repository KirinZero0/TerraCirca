<?php

namespace App\Http\Controllers;

use App\Exports\LaporanBarangExport;
use App\Models\Product;
use App\Models\ProductIn;
use App\Models\ProductList;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProductInController extends Controller
{
    public function index()
    {
        $productIns = ProductIn::where(function ($query) {
            $search = \request()->get('search');
            $query->where('name', 'like', '%' . $search . '%')
            ->orWhereHas('productList', function ($subQuery) use ($search) {
                $subQuery->where('name', 'like', '%' . $search . '%');
            });
    })
        ->orderBy('id', 'DESC')
        ->paginate(10);

        return view('admin.pages.productIn.index', [
            'productIns' => $productIns
        ]);
    }

    public function create()
    {
        $lists = ProductList::all();

        return view('admin.pages.productIn.create', [
            'lists' => $lists
        ]);
    }

    public function edit(ProductIn $productIn)
    {
        return view('admin.pages.barang.edit', [
            'productIn' => $productIn
        ]);
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {

            $productList = ProductList::findOrFail($request->product_list_id);
        
            $productIn = new ProductIn();
            $productIn->fill([
                'product_list_id' => $productList->id,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'date' => $request->date
            ]);
            $productIn->saveOrFail();
        
            $productStock = ProductStock::where('barcode', $request->barcode)->first();
        
            if ($productStock) {
                $productStock->increment('stock', $request->quantity);
            } else {
                $productStock = new ProductStock();
                $productStock->fill([
                    'product_list_id' => $productList->id,
                    'name'            => $productList->name,
                    'barcode'         => $request->barcode,
                    'stock'           => $request->quantity,
                    'price'           => $request->price,
                    'expiration_date' => $request->expiration_date
                ]);
                $productStock->saveOrFail();

                $productIn->update([
                    'product_stock_id' => $productStock->id
                ]);
            }
        });

        return redirect(route('admin.barang.index'));
    }

    public function update(Request $request, ProductIn $productIn)
    {
        $productIn->fill($request->all());
        $productIn->saveOrFail();

        return redirect(route('admin.barang.index'));
    }

    public function destroy(ProductIn $productIn)
    {
        $productIn->delete();

        return redirect(route('admin.barang.index'));
    }
}
