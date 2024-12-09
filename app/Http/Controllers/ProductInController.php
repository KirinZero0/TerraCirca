<?php

namespace App\Http\Controllers;

use App\Exports\LaporanBarangExport;
use App\Models\Product;
use App\Models\ProductIn;
use App\Models\ProductList;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductInController extends Controller
{
    public function index()
    {
        $productIns = ProductIn::where(function ($query) {
            $search = \request()->get('search');
            $query->where('code', 'like', '%' . $search . '%')
            ->orWhereHas('productList', function ($subQuery) use ($search) {
                $subQuery->where('name', 'like', '%' . $search . '%');
            });
    })
        ->orderBy('id', 'DESC')
        ->paginate(10);

        return view('admin.pages.barang.index', [
            'productIns' => $productIns
        ]);
    }

    public function create()
    {
        $lists = ProductList::all();

        return view('admin.pages.barang.create', [
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
        $productIn = new ProductIn();
        $productIn->fill([
            'product_list_id' => $request->product_list_id,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'date' => $request->date
        ]);
        $productIn->saveOrFail();

        

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

    public function updateStatus(Request $request, ProductIn $productIn) //this function only adds stock if the request is approved
    {
        $productIn->status = $request->status;
        $productIn->reasons = $request->reasons;
        $productIn->saveOrFail();

        if ($request->status === ProductIn::APPROVED) {
            $productStock = ProductStock::where('product_list_id', $productIn->product_list_id)->first();
            $productStock->stock += $productIn->quantity;
            $productStock->saveOrFail();
        }

        return redirect(route('admin.barang.index'));
    }

    public function editStatus(ProductIn $product)
    {
        return view('admin.pages.barang.editStatus', [
            'product' => $product
        ]);
    }
}
