<?php
/*
 * author Arya Permana - Kirin
 * created on 16-01-2025-23h-38m
 * github: https://github.com/KirinZero0
 * copyright 2025
*/


namespace App\Http\Controllers;

use App\Enums\ProductStockStatusEnum;
use App\Exports\LaporanBarangExport;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductIn;
use App\Models\ProductList;
use App\Models\ProductOut;
use App\Models\ProductStock;
use App\Traits\UpdateProductStockStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProductCategoryController extends Controller
{
    use UpdateProductStockStatus;
    
    public function index()
    {
        $this->updateProductStockStatuses();
        
        $productCategories = ProductCategory::where(function ($query) {
            $search = \request()->get('search');
            $query->where('name', 'like', '%' . $search . '%');
        })
            ->orderBy('id', 'DESC')
            ->paginate(10);

            return view('admin.pages.productCategory.index', [
            'productCategories' => $productCategories
        ]);
    }

    public function create()
    {
        return view('admin.pages.productCategory.create');
    }

    public function edit(ProductCategory $productCategory)
    {
        return view('admin.pages.productCategory.edit', [
            'productCategory' => $productCategory
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $productCategory = new ProductCategory();
        $productCategory->fill($validated);

        $productCategory->saveOrFail();

        return redirect(route('admin.product.product_category.index'));
    }

    public function update(Request $request, ProductCategory $productCategory)
    {
        $productCategory->fill($request->all());
        $productCategory->saveOrFail();

        return redirect(route('admin.product.product_category.index'));
    }

    public function destroy(ProductCategory $productCategory)
    {
        $productCategory->delete();

        return redirect(route('admin.product.product_category.index'));
    }
}
