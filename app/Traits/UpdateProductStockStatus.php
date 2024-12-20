<?php

namespace App\Traits;

use App\Enums\ProductStockStatusEnum;
use App\Models\ProductStock;
use Illuminate\Support\Facades\DB;

trait UpdateProductStockStatus
{
    /**
     * Update the ProductStock statuses based on quantity and expiration date.
     *
     * UNAVAILABLE: If quantity = 0.
     * EXPIRED: If expiration_date is today or past.
     * NEAR_EXPIRED: If expiration_date is within the next 3 months.
     */
    public function updateProductStockStatuses()
    {
        // Wrap in a transaction for safety
        DB::transaction(function () {
            // Set status to UNAVAILABLE if quantity is 0
            ProductStock::where('stock', 0)
                ->update(['status' => ProductStockStatusEnum::UNAVAILABLE]);

            // Set status to EXPIRED if expiration date is today or earlier
            ProductStock::whereDate('expiration_date', '<=', now())
                ->update(['status' => ProductStockStatusEnum::EXPIRED]);

            // Set status to NEAR_EXPIRED if expiration date is within 3 months
            ProductStock::whereDate('expiration_date', '<=', now()->addMonths(3))
                ->where('status', '!=', ProductStockStatusEnum::EXPIRED) // Avoid overwriting already expired status
                ->update(['status' => ProductStockStatusEnum::NEAR_EXPIRED]);
        });
    }
}
