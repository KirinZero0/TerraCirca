<?php
/*
 * author Arya Permana - Kirin
 * created on 13-12-2024-22h-34m
 * github: https://github.com/KirinZero0
 * copyright 2024
*/

namespace App\Models;

use App\Models\Traits\HandleUpload;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionItem extends Model
{
    use HasFactory;

    protected $table = 'transaction_items';

    protected $guarded = [
    ];

    public function Transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function productStock(): BelongsTo
    {
        return $this->belongsTo(ProductStock::class, 'product_stock_id');
    }
}
