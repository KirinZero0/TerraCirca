<?php

namespace App\Http\Controllers;

use App\Enums\ProductStockStatusEnum;
use App\Exports\LaporanBarangExport;
use App\Models\Product;
use App\Models\ProductIn;
use App\Models\ProductList;
use App\Models\ProductOut;
use App\Models\ProductStock;
use App\Traits\UpdateProductStockStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProductOutController extends Controller
{
    use UpdateProductStockStatus;
    
    public function index()
    {
        $this->updateProductStockStatuses();

        $productOuts = ProductOut::whereHas('productList', function ($query) {
            $search = request()->get('search');
            $query->where('name', 'like', '%' . $search . '%');
        })
        ->orderBy('id', 'DESC')
        ->paginate(10);

        return view('admin.pages.productOut.index', [
            'productOuts' => $productOuts
        ]);
    }

    public function create()
    {
        $stocks = ProductStock::all();

        return view('admin.pages.productOut.create', [
            'stocks' => $stocks
        ]);
    }

    public function edit(ProductOut $productOut)
    {
        return view('admin.pages.productOut.edit', [
            'productOut' => $productOut
        ]);
    }

    public function store(Request $request)
    {    
        DB::transaction(function () use ($request) {
            try {
                // dd($request->product_stock_id);
                $productStock = ProductStock::findOrFail($request->product_stock_id);
                $productOut = new ProductOut([
                    'product_list_id' => $productStock->productList->id,
                    'product_stock_id' => $productStock->id,
                    'quantity' => $request->quantity,
                    'type'  => $request->type,
                    'date' => $request->date
                ]);
                $productOut->saveOrFail();
    
                $productStock->decrement('stock', $request->quantity);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Something went wrong, please try again.');
            }
        });
        return redirect(route('admin.product.product_out.index'))->with('success', 'Product out registered successfully.');
    }

    public function update(Request $request, ProductOut $productOut)
    {
        $productOut->fill($request->all());
        $productOut->saveOrFail();

        return redirect(route('admin.product.product_out.index'));
    }

    public function destroy(ProductOut $productOut)
    {
        $productOut->delete();

        return redirect(route('admin.product.product_out.index'));
    }

    public function undo(ProductOut $productOut)
    {
        $productStock = $productOut->productStock;
        $productStock->increment('stock', $productOut->quantity);

        $productOut->delete();
    
        return redirect(route('admin.product.product_out.index'))->with('success', 'Product out undone and stock restored.');
    }
}
