<?php
/*
 * author Arya Permana - Kirin
 * created on 14-12-2024-10h-22m
 * github: https://github.com/KirinZero0
 * copyright 2024
*/

namespace App\Models;

use App\Models\Traits\HandleUpload;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PatientCheckup extends Model
{
    use HasFactory;

    protected $table = 'patient_checkups';

    protected $guarded = [
    ];

    protected $dates = ['date'];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
