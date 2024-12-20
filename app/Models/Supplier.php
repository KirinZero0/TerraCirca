<?php
/*
 * author Arya Permana - Kirin
 * created on 05-12-2024-21h-42m
 * github: https://github.com/KirinZero0
 * copyright 2024
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;

    protected $guarded = [
    ];

    public function products(): HasMany
    {
        return $this->hasMany(ProductList::class,  'supplier_id');
    }

}
