<?php
/*
 * author Arya Permana - Kirin
 * created on 19-01-2025-13h-30m
 * github: https://github.com/KirinZero0
 * copyright 2025
*/


namespace App\Http\Controllers;

use App\Models\ProductStock;
use App\Models\ProductStockAudit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductStockAuditController extends Controller
{   
    public function create(ProductStock $productStock)
    {
        return view('admin.pages.productStockAudit.create', [
            'productStock' => $productStock
        ]);
    }

    public function edit(ProductStock $productStock)
    {
        return view('admin.pages.productStockAudit.edit', [
            'productStock' => $productStock
        ]);
    }

    public function store(ProductStock $productStock, Request $request)
    {    
        DB::transaction(function () use ($productStock, $request) {
            try {
                $audit = new ProductStockAudit([
                    'product_stock_id' => $productStock->id,
                    'admin_id' => $request->user()->id,
                    'previous_stock' => $productStock->stock,
                    'audited_stock'  => $request->audited_stock,
                    'note' => $request->note,
                    'audit_date' => now()
                ]);
                $audit->saveOrFail();
    
                $productStock->update([
                    'stock' => $request->audited_stock,
                ]);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Something went wrong, please try again.');
            }
        });
        return redirect(route('admin.product.product_stock.show', $productStock->id))->with('success', 'Product out registered successfully.');
    }

    public function undo(ProductStockAudit $productStockAudit)
    {
        $productStock = $productStockAudit->productStock;
        $productStock->update([
            'stock' => $productStockAudit->previous_stock,
        ]);

        $productStockAudit->delete();
    
        return redirect(route('admin.product.product_stock.show', $productStock->id))->with('success', 'stock audit undone and stock restored.');
    }
}
