<?php
/*
 * author Arya Permana - Kirin
 * created on 14-12-2024-11h-46m
 * github: https://github.com/KirinZero0
 * copyright 2024
*/

namespace App\Http\Controllers;

use App\Enums\ProductStockStatusEnum;
use App\Enums\TransactionStatusEnum;
use App\Exports\LaporanBarangExport;
use App\Models\Patient;
use App\Models\PatientCheckup;
use App\Models\Product;
use App\Models\ProductIn;
use App\Models\ProductList;
use App\Models\ProductStock;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Traits\UpdateProductStockStatus;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductStockController extends Controller
{
    use UpdateProductStockStatus;

    public function index()
    {
        $this->updateProductStockStatuses();
    
        $search = \request()->get('search');
    
        $productStocks = ProductStock::where(function ($query) use ($search) {
            if ($search) {
                $query->where('barcode', 'like', '%' . $search . '%')
                        ->orWhere('name', 'like', '%' . $search . '%');
            }
        })
            ->orderByRaw("FIELD(status, 'Available', 'Near Expired', 'Expired', 'Unavailable')")
            ->orderBy('id', 'DESC')
            ->paginate(10);
    
        return view('admin.pages.productStock.index', [
            'productStocks' => $productStocks
        ]);
    }

    public function markAsUnavailable(ProductStock $productStock)
    {
        $productStock->status = ProductStockStatusEnum::UNAVAILABLE; // Assuming you have an enum or constant for 'Unavailable'
        $productStock->save();

        return redirect(route('admin.product.product_stock.show', $productStock->id));
    }

    public function show(ProductStock $productStock)
    {
        $productOuts = $productStock->productOuts()->where('type', 'like', '%' . request()->get('search') . '%')
        ->get();

        $audits      = $productStock->audits;

        return view('admin.pages.productStock.view', [
            'stock'  => $productStock,
            'productOuts'   => $productOuts,
            'audits'        => $audits
        ]);
    }

    public function edit(ProductStock $productStock)
    {
        return view('admin.pages.productStock.edit', [
            'stock'  => $productStock,
        ]);
    }
    public function update(ProductStock $productStock, Request $request)
    {
        $productStock->fill($request->all());
        $productStock->saveOrFail();
    
        return redirect(route('admin.product.product_stock.show', $productStock->id));
    }

    public function destroy(ProductStock $productStock)
    {
        $productStock->delete();

        return redirect(route('admin.supplier.index'));
    }
}
