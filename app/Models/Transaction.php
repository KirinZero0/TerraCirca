<?php
/*
 * author Arya Permana - Kirin
 * created on 13-12-2024-22h-32m
 * github: https://github.com/KirinZero0
 * copyright 2024
*/


namespace App\Models;

use App\Models\Traits\HandleUpload;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $guarded = [
    ];

    protected $dates = ['date'];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function transactionItems(): HasMany
    {
        return $this->hasMany(TransactionItem::class, 'transaction_id');
    }

    public function calculateTotalAmount()
{
    $this->total_amount = $this->transactionItems()->sum('total_amount');
    $this->save();
}
}
