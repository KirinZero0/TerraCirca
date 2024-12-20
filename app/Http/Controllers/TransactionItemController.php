<?php

namespace App\Http\Controllers;

use App\Enums\ProductStockStatusEnum;
use App\Enums\TransactionStatusEnum;
use App\Models\Order;
use App\Models\ProductStock;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionItemController extends Controller
{
    public function store(Transaction $transaction, Request $request)
    {
        $productStockId = null;
        $warningMessage = null;
    
        if ($request->barcode) {
            $productStock = ProductStock::where('barcode', $request->barcode)->first();
        } else {
            $productStock = ProductStock::find($request->product_stock_id);
        }

        if (!$productStock) {
            return redirect()->back()->with('error', 'Product does not exist or has not been inputted.');
        }

       
        if ($productStock->status == ProductStockStatusEnum::NEAR_EXPIRED) {
                $warningMessage = 'Warning: The product is nearing expiration (within 3 months).';
            }
        
    
        if ($transaction->status == TransactionStatusEnum::ONGOING) {
            $existingItem = $transaction->transactionItems()
                ->where('product_stock_id', $productStockId)
                ->first();
    
            if ($existingItem) {
                $existingItem->increment('quantity', $request->quantity);

                $newQuantity = $existingItem->quantity;
                $newTotalAmount = $newQuantity * $productStock->selling_price;

                $existingItem->update([
                    'total_amount' => $newTotalAmount,
                ]);
            } else {
                $transaction->transactionItems()->create([
                    'product_stock_id' => $productStock->id,
                    'quantity' => $request->quantity,
                    'total_amount' => $productStock->selling_price * $request->quantity
                ]);
            }
    
            $transaction->calculateTotalAmount();

            if ($warningMessage) {
                return redirect()->back()
                    ->with('success', 'Order added successfully.')
                    ->with('warning', $warningMessage);
            }
    
            return redirect()->back()->with('success', 'Order added successfully.');
        }
    
        return redirect()->back()->with('error', 'Transaction is already finished.');
    }

    public function update(TransactionItem $transactionItem, Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $productStock = ProductStock::find($transactionItem->productStock);

        if (!$productStock) {
            return redirect()->back()->with('error', 'Related product stock does not exist.');
        }

        $transactionItem->quantity = $request->quantity;
        $transactionItem->total_amount = $request->quantity * $productStock->selling_price;
        $transactionItem->save();

        $transactionItem->Transaction->calculateTotalAmount();

        return redirect()->back()->with('success', 'Transaction item updated successfully.');
    }

    public function destroy(TransactionItem $transactionItem)
    {
        $transactionItem->delete();

        $transactionItem->transaction->calculateTotalAmount();
        
        return redirect()->back()->with('success', 'Order deleted successfully.');
    }
}
