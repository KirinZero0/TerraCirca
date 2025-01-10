<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductIn;
use App\Models\ProductList;
use App\Models\ProductOut;
use App\Models\ProductStock;
use App\Models\Supplier;
use App\Traits\UpdateProductStockStatus;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductListController extends Controller
{
    use UpdateProductStockStatus;
    public function index()
    {
        $this->updateProductStockStatuses();
        
        $productLists = ProductList::where(function ($query) {
            $search = \request()->get('search');
            $query->where('code', 'like', '%' . $search . '%')
                ->orWhere('name', 'like', '%' . $search . '%')
                ->orWhere('indication', 'like', '%' . $search . '%');
        })
            ->orderBy('id', 'DESC')
            ->paginate(10);

         return view('admin.pages.productList.index', [
            'productLists' => $productLists
     ]);
    }

    public function create()
    {
        $suppliers = Supplier::all();
        return view('admin.pages.productList.create', [
            'suppliers' => $suppliers
        ]);
    }

    public function show (ProductList $productList)
    {
        $stocks = $productList->productStocks()
        ->where('barcode', 'like', '%' . request()->get('search') . '%')
        ->get();
    
        return view('admin.pages.productList.view', [
            'product' => $productList,
            'stocks' => $stocks
        ]);
    }

    public function edit(ProductList $productList)
    {        
        $suppliers = Supplier::all();
        return view('admin.pages.productList.edit', [
            'productList' => $productList,
            'suppliers' => $suppliers
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:product_lists,code',
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'indication' => 'required|string|max:255',
            'type' => 'sometimes|string|max:255',
            'supplier_id' => 'required|integer|exists:suppliers,id',
        ]);

        $productList = new ProductList();
        $productList->fill($validated);

        $productList->saveOrFail();

        return redirect(route('admin.product.product_list.index'));
    }


    public function update(Request $request, ProductList $productList)
    {
        $productList->fill($request->all());
        $productList->saveOrFail();

        return redirect(route('admin.product.product_list.index'));
    }

    public function destroy(ProductList $productList)
    {

        ProductIn::where('product_list_id', $productList->id)->delete();
        ProductOut::where('product_list_id', $productList->id)->delete();
        ProductStock::where('product_list_id', $productList->id)->delete();

        $productList->delete();

        return redirect(route('admin.product.product_list.index'));
    }
}
