<?php
/*
 * author Arya Permana - Kirin
 * created on 05-12-2024-21h-41m
 * github: https://github.com/KirinZero0
 * copyright 2024
*/


namespace App\Http\Controllers;

use App\Exports\LaporanBarangExport;
use App\Models\Product;
use App\Models\ProductIn;
use App\Models\ProductList;
use App\Models\ProductStock;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::where(function ($query) {
            $search = \request()->get('search');
            $query->where('name', 'like', '%' . $search . '%');
    })
        ->orderBy('id', 'DESC')
        ->paginate(10);

        return view('admin.pages.supplier.index', [
            'suppliers' => $suppliers
        ]);
    }

    public function create()
    {
        return view('admin.pages.supplier.create');
    }

    public function edit(Supplier $supplier)
    {
        return view('admin.pages.supplier.edit', [
            'supplier' => $supplier
        ]);
    }

    public function store(Request $request)
    {
        $supplier = new Supplier();
        $supplier->fill([
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email
        ]);
        $supplier->saveOrFail();

        return redirect(route('admin.supplier.index'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $supplier->fill($request->all());
        $supplier->saveOrFail();

        return redirect(route('admin.supplier.index'));
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect(route('admin.supplier.index'));
    }
}
