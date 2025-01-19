<?php
/*
 * author Arya Permana - Kirin
 * created on 14-12-2024-11h-03m
 * github: https://github.com/KirinZero0
 * copyright 2024
*/


namespace App\Http\Controllers;

use App\Enums\ProductOutTypeEnum;
use App\Enums\ProductStockStatusEnum;
use App\Enums\TransactionStatusEnum;
use App\Exports\LaporanBarangExport;
use App\Exports\LaporanTransaksi;
use App\Exports\LaporanTransaksiToday;
use App\Models\Patient;
use App\Models\PatientCheckup;
use App\Models\Product;
use App\Models\ProductIn;
use App\Models\ProductList;
use App\Models\ProductOut;
use App\Models\ProductStock;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Traits\UpdateProductStockStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{
    use UpdateProductStockStatus;

    public function index()
    {
        $this->updateProductStockStatuses();

        $transactions = Transaction::where(function ($query) {
            $search = \request()->get('search');
            $query->where('reference_id', 'like', '%' . $search . '%');
        })
        ->whereDate('date', today())
        ->orderBy('id', 'DESC')
        ->paginate(10);

        session()->put('today', today());

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
                    ->orWhereHas('productList', function ($query) {
                        $search = \request()->get('search');
                        $query->where('indication', 'like', '%' . $search . '%');
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
            'admin_id' => $request->user()->id,
        ]);
        $transaction->saveOrFail();

        return redirect(route('admin.transaction.show', ['transaction' => $transaction->id]));
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
    
        return redirect(route('admin.transaction.show', ['transaction' => $transaction->id]));
    }

    public function finish(Transaction $transaction, Request $request)
    {
        DB::transaction(function () use ($transaction, $request) {

    
            foreach ($transaction->transactionItems as $transactionItem) {
                $productOut = new ProductOut();
                $productOut->type = ProductOutTypeEnum::TRANSACTION;
                $productOut->transaction_id = $transaction->id;
                $productOut->product_list_id = $transactionItem->productStock->productList->id;
                $productOut->product_stock_id = $transactionItem->productStock->id;
                $productOut->quantity = $transactionItem->quantity;
                $productOut->date = now();
                $productOut->saveOrFail();

                $productStock = $transactionItem->productStock;
                $quantity = $transactionItem->quantity;
            
                $productStock->decrement('stock', $quantity);
            
            }

            $transaction->paid_amount = $request->paid_amount;
            if($request->paid_amount > $transaction->total_amount)
            {
                $transaction->change_amount = $request->paid_amount - $transaction->total_amount;
            } else {
                $transaction->change_amount = 0;
            }
            $transaction->status = TransactionStatusEnum::FINISHED;
            $transaction->saveOrFail();
        });
    
        return redirect(route('admin.transaction.finish.show', $transaction->id))->with('success', 'Transaction finished and product stock updated.');
    }

    public function finishShow(Transaction $transaction)
    {
        $items = $transaction->transactionItems;
        return view('admin.pages.transaction.finish', [
            'transaction' => $transaction,
            'items' => $items,
        ]);
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect(route('admin.supplier.index'));
    }

    public function export()
    {
        return Excel::download(new LaporanTransaksiToday(), now()->format('Y-m-d').'-laporan-transaksi.xlsx');
    }
}
