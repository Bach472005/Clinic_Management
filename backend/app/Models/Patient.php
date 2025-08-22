<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'nickname', 'dob', 'gender', 'notes', 'address', 'occupation', 'user_id'
    ];

    public function user() 
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }
    public function appointments()
    {
        return $this->hasMany(
            Appointment::class,
            'patient_id'
        );
    }
    public function medical_records() 
    {
        return $this->hasMany(
            MedicalRecord::class,
        );
    }
}
