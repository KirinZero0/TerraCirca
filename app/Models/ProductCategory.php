<?php
/*
 * author Arya Permana - Kirin
 * created on 16-01-2025-23h-08m
 * github: https://github.com/KirinZero0
 * copyright 2025
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductCategory extends Model
{
    use HasFactory;

    protected $table = 'product_categories';

    protected $guarded = [
    ];

    public function productList(): HasMany
    {
        return $this->hasMany(ProductList::class, 'product_category_id');
    }
}
