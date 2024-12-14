<?php
/*
 * author Arya Permana - Kirin
 * created on 14-12-2024-10h-20m
 * github: https://github.com/KirinZero0
 * copyright 2024
*/

namespace App\Models;

use App\Models\Traits\HandleUpload;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients';

    protected $guarded = [
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'patient_id');
    }

    public function checkups(): HasMany
    {
        return $this->hasMany(PatientCheckup::class, 'patient_id');
    }
}
