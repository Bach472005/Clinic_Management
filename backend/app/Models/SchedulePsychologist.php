<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchedulePsychologist extends Model
{
    use HasFactory;

    protected $fillable = [
        'available_date', 'start_time', 'end_time', 'is_booked'
    ];

    public function appointments()
    {
        return $this->hasOne(Appointment::class, 'schedule_id');
    }
}
