<?php
/*
 * author Arya Permana - Kirin
 * created on 14-12-2024-11h-46m
 * github: https://github.com/KirinZero0
 * copyright 2024
*/

namespace App\Http\Controllers;

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
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductStockController extends Controller
{
    public function show(ProductStock $productStock)
    {
        $productIn = $productStock->productIn;
        $productList = $productStock->productList;

        return view('admin.pages.supplier.edit', [
            'productList' => $productList,
            'productIn' => $productIn,
            'productStock'  => $productStock
        ]);
    }

    public function update(ProductStock $productStock, Request $request)
    {
        $productStock->fill($request->all());
        $productStock->saveOrFail();
    
        return redirect(route('admin.supplier.index'));
    }

    public function destroy(ProductStock $productStock)
    {
        $productStock->delete();

        return redirect(route('admin.supplier.index'));
    }
}
