<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_time', 'method', 'status', 'notes'
    ];

    public function patient()
    {
        return $this->belongsTo(
            Patient::class
        );
    }

    public function psychologist()
    {
        return $this->belongsTo(
            Psychologist::class
        );
    }

    public function feedBack()
    {
        return $this->hasOne(
            FeedBack::class
        );
    }
}
