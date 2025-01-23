<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductList extends Model
{
    use HasFactory;

    protected $guarded = [
    ];

    public function productCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function productStocks(): HasMany
    {
        return $this->hasMany(ProductStock::class, 'product_list_id');
    }

    public function currentProductStock(): BelongsTo
    {
        return $this->belongsTo(ProductStock::class, 'current_product_stock_id');
    }

    public function productIns(): HasMany
    {
        return $this->hasMany(ProductIn::class, 'product_list_id');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
