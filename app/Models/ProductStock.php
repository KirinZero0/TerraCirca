<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductStock extends Model
{
    use HasFactory;

    protected $table = 'product_stocks';

    protected $guarded = [
    ];

    protected $dates = ['expiration_date'];

    public function productList(): BelongsTo
    {
        return $this->belongsTo(ProductList::class, 'product_list_id');
    }

    public function productIn(): BelongsTo
    {
        return $this->belongsTo(ProductIn::class, 'product_stock_id');
    }
}
