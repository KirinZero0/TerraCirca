<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'menu_id',
        'quantity',
        'status'
    ];

    const DONE = 'DONE';
    const PENDING = 'PENDING';

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function getTotalPriceAttribute()
    {
        return $this->quantity * $this->menu->price;
    }
}
