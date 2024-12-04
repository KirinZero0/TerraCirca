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

    protected $fillable = [
        'product_list_id',
        'code',
        'price',
        'quantity',
        'date',
        'status',
        'reasons'
    ];

    const PENDING   = "PENDING";
    const REJECTED  = "REJECTED";
    const APPROVED  = "APPROVED";

    protected $dates = ['date'];

    public function getStatus()
    {
        if($this->status == self::PENDING) return 'Menunggu Persetujuan';
        if($this->status == self::REJECTED) return 'Ditolak';

        return 'Disetujui';
    }

    public function getStatusColor()
    {
        if($this->status == self::PENDING) return 'badge badge-warning';
        if($this->status == self::REJECTED) return 'badge badge-danger';

        return 'badge badge-success';
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(ProductList::class, 'product_list_id');
    }
}
