<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductOut extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_list_id',
        'code',
        'quantity',
        'date',
        'type',
        'reasons'
    ];

    const KELUAR = "KELUAR";
    const RETURN = "RETURN";

    protected $dates = ['date'];


    protected $attributes = [
        'type' => self::KELUAR
    ];

    public function getType()
    {
        if($this->type == self::RETURN) return 'Barang Retur';

        return 'Barang Keluar';
    }

    public function getTypeColor()
    {
        if($this->type == self::RETURN) return 'badge badge-warning';
        
        return 'badge badge-danger';
    }

    public function isBarangKeluar(): bool
    {
        return $this->type == self::KELUAR;
    }

    public function isBarangReturn(): bool
    {
        return $this->type == self::RETURN;
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(ProductList::class, 'product_list_id');
    }

}
