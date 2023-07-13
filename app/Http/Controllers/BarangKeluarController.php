<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductList;
use App\Models\ProductOut;
use App\Models\ProductStock;
use Illuminate\Http\Request;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $products = ProductOut::where(function ($query) {
            $search = \request()->get('search');
            $query->where('code', 'like', '%' . $search . '%')
            ->orWhereHas('product', function ($subQuery) use ($search) {
                $subQuery->where('name', 'like', '%' . $search . '%');
            });
    })
        ->orderBy('id', 'DESC')
        ->paginate(10);

        return view('admin.pages.barang.keluar.index', [
            'products' => $products
        ]);
    }

    public function create()
    {
        $lists = ProductList::with('productStock')->get();

        return view('admin.pages.barang.keluar.create', [
            'code'  => rand(),
            'lists' => $lists
        ]);
    }

    public function edit(ProductOut $product)
    {
        $maxQuantity = ProductStock::where('code', $product->code)->value('stock');

        return view('admin.pages.barang.keluar.edit', [
            'product' => $product,
            'maxQuantity' => $maxQuantity
        ]);
    }

    public function store(Request $request)
    {
        $list = ProductList::where('custom_id', $request->code)->first();

        $product = new ProductOut();
        $product->fill([
            'product_list_id' => $list->id,
            'code' => $request->code,
            'quantity' => $request->quantity,
            'status' => $request->status,
            'reasons' => $request->reasons,
            'date' => $request->date,

        ]);
        $product->saveOrFail();

        $productStock = ProductStock::where('code', $request->code)->first();
        if ($productStock) {
            $productStock->stock -= $request->quantity;
            $productStock->save();
        }
    
        return redirect(route('admin.barang.keluar.index'));
    }

    public function update(Request $request, ProductOut $product) 
    {
        $originalQuantity = $product->quantity; 
    
        $product->fill($request->all());
        $product->saveOrFail();
    
        $updatedQuantity = $product->quantity; 
    
        // Compare the original quantity with the updated quantity
        if ($updatedQuantity > $originalQuantity) {
            $quantityDifference = $updatedQuantity - $originalQuantity;
            // Decrease the stock in ProductStock by the quantity difference
            $productStock = ProductStock::where('code', $product->code)->first();
            if ($productStock) {
                $productStock->stock -= $quantityDifference;
                $productStock->save();
            }
        } elseif ($updatedQuantity < $originalQuantity) {
            $quantityDifference = $originalQuantity - $updatedQuantity;
            // Increase the stock in ProductStock by the quantity difference
            $productStock = ProductStock::where('code', $product->code)->first();
            if ($productStock) {
                $productStock->stock += $quantityDifference;
                $productStock->save();
            }
        }
    
        return redirect(route('admin.barang.keluar.index'));
    }

    public function destroy(ProductOut $product) //more like a cancel function , it rollbacks the store function
    {
        $quantity = $product->quantity;
    
        $productStock = ProductStock::where('code', $product->code)->first();
    
        if ($productStock) {
            $productStock->stock += $quantity;
            $productStock->save();
        }
    
        $product->delete();
    
        return redirect(route('admin.barang.keluar.index'));
    }
    public function updateStatus(Request $request, Product $product)
    {
        $product->status = $request->status;
        $product->reasons = $request->reasons;
        $product->saveOrFail();

        if ($request->status === Product::APPROVED) {
            $productStock = ProductStock::where('product_list_id', $product->product_list_id)->first();
            $productStock->stock += $product->quantity;
            $productStock->saveOrFail();
        }

        return redirect(route('admin.barang.index'));
    }

    public function editStatus(Product $product)
    {
        return view('admin.pages.barang.editStatus', [
            'product' => $product
        ]);
    }
}
