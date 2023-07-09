<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_id',
        'table_number',
        'number_of_people',
        'date',
        'status',
    ];

    const PENDING = "PENDING";
    const PROGRESS = "PROGRESS";
    const FINISH = "FINISH";
    const CANCEL = "CANCEL";

    public function getStatus()
    {
        if($this->status == self::PENDING) return 'Pending';
        if($this->status == self::PROGRESS) return 'In Progress';
        if($this->status == self::CANCEL) return 'Canceled';

        return 'Finished';
    }

    public function getStatusColor()
    {
        if($this->status == self::PENDING) return 'badge badge-warning';
        if($this->status == self::PROGRESS) return 'badge badge-danger';
        if($this->status == self::CANCEL) return 'badge badge-danger';

        return 'badge badge-success';
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'reservation_id');
    }

    public function getSubtotalAttribute()
    {
        return $this->orders->sum(function ($order) {
            return $order->getSubtotalAttribute();
        });
    }
}
