<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'method', 'status', 'notes', 'version', 'patient_id', 'psychologist_id', 'schedule_id', 'modified_id'
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
    public function schedule()
    {
        return $this->belongsTo(SchedulePsychologist::class, 'schedule_id');
    }
    public function feedBack()
    {
        return $this->hasOne(
            FeedBack::class
        );
    }
}
