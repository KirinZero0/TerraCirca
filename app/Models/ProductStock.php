<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductStock extends Model
{
    use HasFactory;

    protected $guarded = [
    ];

    public function productList(): BelongsTo
    {
        return $this->belongsTo(ProductList::class, 'product_list_id')->onDelete('cascade');
    }

    public function productIn(): BelongsTo
    {
        return $this->belongsTo(ProductIn::class, 'product_stock_id')->onDelete('cascade');
    }
}
