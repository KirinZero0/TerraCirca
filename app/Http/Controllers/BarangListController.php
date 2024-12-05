<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductIn;
use App\Models\ProductList;
use App\Models\ProductOut;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BarangListController extends Controller
{
    public function index()
    {
        $products = ProductList::where(function ($query) {
            $search = \request()->get('search');
            $query->where('code', 'like', '%' . $search . '%')
                ->orWhere('name', 'like', '%' . $search . '%');
        })
            ->orderBy('id', 'DESC')
            ->paginate(10);

     return view('admin.pages.barang.list.index', [
         'products' => $products
     ]);
    }

    public function create()
    {
        return view('admin.pages.barang.list.create');
    }

    public function edit( ProductList $product)
    {
        return view('admin.pages.barang.list.edit', [
            'product' => $product
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', Rule::unique('product_lists')->whereNull('deleted_at')],
            'name' => ['required']
        ], [
            'custom_id.unique' => 'Kode barang sudah digunakan '
        ]);

        $listProduct = new ProductList();
        $listProduct->fill($request->all());
        $listProduct->saveOrFail();

        // $productStock = new ProductStock();
        // $productStock->product_list_id = $listProduct->id;
        // $productStock->code = $listProduct->custom_id;
        // $productStock->name = $listProduct->name;
        // $productStock->saveOrFail();

        return redirect(route('admin.barang.list.index'));
    }


    public function update(Request $request, ProductList $product)
    {
        $product->fill($request->all());
        $product->saveOrFail();

        return redirect(route('admin.barang.list.index'));
    }

    public function destroy(ProductList $product)
    {

        ProductIn::where('product_list_id', $product->id)->delete();
        ProductOut::where('product_list_id', $product->id)->delete();
        ProductStock::where('product_list_id', $product->id)->delete();

        $product->delete();

        return redirect(route('admin.barang.list.index'));
    }
}
