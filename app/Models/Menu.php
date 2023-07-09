<?php

namespace App\Models;

use App\Models\Traits\HandleUpload;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory, HandleUpload;

    protected $fillable = [
        'custom_id',
        'name',
        'price',
        'description',
        'type',
        'photo',
    ];

    const MAKANAN = "MAKANAN";
    const MINUMAN = "MINUMAN";

    public function getType()
    {
        if($this->type == self::MAKANAN) return 'Makanan';
        if($this->type == self::MINUMAN) return 'Minuman';

        return 'Lainnya';
    }
}
