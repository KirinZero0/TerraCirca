<?php

namespace App\Models;

use App\Models\Traits\HandleUpload;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductIn extends Model
{
    use HasFactory;

    protected $table = 'product_ins';

    protected $guarded = [
    ];

    protected $dates = ['date'];

    public function productList(): BelongsTo
    {
        return $this->belongsTo(ProductList::class, 'product_list_id');
    }
}
