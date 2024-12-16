<?php
/*
 * author Arya Permana - Kirin
 * created on 14-12-2024-11h-03m
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
use App\Models\ProductOut;
use App\Models\ProductStock;
use App\Models\Supplier;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where(function ($query) {
            $search = \request()->get('search');
            $query->where('reference_id', 'like', '%' . $search . '%');
    })
        ->orderBy('id', 'DESC')
        ->paginate(10);

        return view('admin.pages.transaction.index', [
            'transactions' => $transactions
        ]);
    }

    public function show(Transaction $transaction)
    {
        $transactionItems = $transaction->transactionItems;
        $patients = Patient::where('name', 'like', '%'.\request()->get('search').'%')
                    ->orWhere('phone', 'like', '%'.\request()->get('search').'%')
                    ->get();

        $productStocks = ProductStock::whereNotIn('status', [
                        ProductStockStatusEnum::UNAVAILABLE, 
                        ProductStockStatusEnum::EXPIRED
                    ])
                    ->where(function ($query) {
                        $search = \request()->get('search');
                        $query->where('barcode', 'like', '%' . $search . '%')
                            ->orWhere('name', 'like', '%' . $search . '%');
                    })
                    ->get();

        return view('admin.pages.transaction.view', [
            'transaction' => $transaction,
            'transactionItems' => $transactionItems,
            'patients'  => $patients,
            'productStocks' => $productStocks
        ]);
    }

    public function store(Request $request)
    {
        $lastTransactionId = Transaction::max('id');
        $nextTransactionId = $lastTransactionId ? $lastTransactionId + 1 : 1;
    
        $ref = 'TRNS-' . $nextTransactionId;
    
        $transaction = new Transaction();
        $transaction->fill([
            'reference_id' => $ref,
            'date' => now(),
            'status' => TransactionStatusEnum::ONGOING,
        ]);
        $transaction->saveOrFail();

        return redirect(route('admin.transaction.show'));
    }

    public function update(Transaction $transaction, Request $request)
    {
        $transaction->fill($request->all());
        $transaction->saveOrFail();
    
        if ($request->has('patient_id')) {
            PatientCheckup::create([
                'transaction_id' => $transaction->id, 
                'patient_id' => $request->patient_id,
                'date' => now(), 
            ]);
        }
    
        return redirect(route('admin.supplier.index'));
    }

    public function finish(Transaction $transaction)
    {
        DB::transaction(function () use ($transaction) {
            $productOut = new ProductOut();
            $productOut->type = 'Transaction';
            $productOut->transaction_id = $transaction->id;
            $productOut->date = now();
            $productOut->saveOrFail();
    
            foreach ($transaction->transactionItems as $transactionItem) {
                $productStock = $transactionItem->productStock;
                $quantity = $transactionItem->quantity;
    
                $productStock->decrement('quantity', $quantity);
    
            }
    
            $transaction->status = TransactionStatusEnum::FINISHED;
            $transaction->saveOrFail();
        });
    
        return redirect(route('admin.supplier.index'))->with('success', 'Transaction finished and product stock updated.');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect(route('admin.supplier.index'));
    }
}
