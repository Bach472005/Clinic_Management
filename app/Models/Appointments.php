<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_time', 'method', 'status', 'notes'
    ];

    public function patient()
    {
        return $this->belongsTo(
            Patients::class
        );
    }

    public function psychologist()
    {
        return $this->belongsTo(
            Psychologists::class
        );
    }
}
