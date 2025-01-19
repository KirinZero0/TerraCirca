<?php
/*
 * author Arya Permana - Kirin
 * created on 19-01-2025-13h-26m
 * github: https://github.com/KirinZero0
 * copyright 2025
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductStockAudit extends Model
{
    use HasFactory;

    protected $table = 'product_stock_audits';

    protected $guarded = [
    ];

    protected $dates = ['audit_date'];

    public function productStock(): BelongsTo
    {
        return $this->belongsTo(ProductStock::class, 'product_stock_id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
