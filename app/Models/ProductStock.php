<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function productIns(): HasMany
    {
        return $this->hasMany(ProductIn::class, 'product_stock_id');
    }
    
    public function productOuts(): HasMany
    {
        return $this->hasMany(ProductOut::class, 'product_stock_id');
    }
}
