<?php

namespace App\Http\Controllers;

use App\Enums\ProductStockStatusEnum;
use App\Models\Product;
use App\Models\ProductIn;
use App\Models\ProductList;
use App\Models\ProductOut;
use App\Models\ProductStock;
use Illuminate\Http\Request;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $productOuts = ProductOut::where(function ($query) {
            $search = \request()->get('search');
            $query->where('type', 'like', '%' . $search . '%')
            ->orWhereHas('productStock', function ($subQuery) use ($search) {
                $subQuery->where('name', 'like', '%' . $search . '%');
            });
    })
        ->orderBy('id', 'DESC')
        ->paginate(10);

        return view('admin.pages.barang.keluar.index', [
            'productOuts' => $productOuts
        ]);
    }

    public function create()
    {
        $productStocks = ProductStock::where('status', '!=', ProductStockStatusEnum::UNAVAILABLE)->get();

        return view('admin.pages.barang.keluar.create', [
            'productStocks' => $productStocks
        ]);
    }

    public function edit(ProductOut $productOut)
    {
        $maxQuantity = $productOut->productStock->stock;

        return view('admin.pages.barang.keluar.edit', [
            'productOut' => $productOut,
            'maxQuantity' => $maxQuantity
        ]);
    }

    public function store(Request $request)
    {
        $productStock = ProductStock::find($request->product_stock_id)->first();

        $productOut = new ProductOut();
        $productOut->fill([
            'product_list_id' => $productStock->product_list_id,
            'product_stock_id' => $productStock->id,
            'quantity' => $request->quantity,
            'type' => $request->type,
            'date' => $request->date,

        ]);
        $productOut->saveOrFail();

        if ($productStock) {
            $productStock->stock -= $request->quantity;
            $productStock->save();
        }
    
        return redirect(route('admin.barang.keluar.index'));
    }

    public function update(Request $request, ProductOut $productOut) 
    {
        $originalQuantity = $productOut->quantity; 
    
        $productOut->fill($request->all());
        $productOut->saveOrFail();
    
        $updatedQuantity = $productOut->quantity; 
    
        if ($updatedQuantity > $originalQuantity) {
            $quantityDifference = $updatedQuantity - $originalQuantity;
            $productStock = $productOut->productStock;
            if ($productStock) {
                $productStock->stock -= $quantityDifference;
                $productStock->save();
            }
        } elseif ($updatedQuantity < $originalQuantity) {
            $quantityDifference = $originalQuantity - $updatedQuantity;
            $productStock = $productOut->productStock;
            if ($productStock) {
                $productStock->stock += $quantityDifference;
                $productStock->save();
            }
        }
    
        return redirect(route('admin.barang.keluar.index'));
    }

    public function destroy(ProductOut $productOut) //more like a cancel function , it rollbacks the store function
    {
        $quantity = $productOut->quantity;
    
        $productStock = $productOut->productStock;
    
        if ($productStock) {
            $productStock->stock += $quantity;
            $productStock->save();
        }
    
        $productOut->delete();
    
        return redirect(route('admin.barang.keluar.index'));
    }
}
