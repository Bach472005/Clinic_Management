<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patients extends Model
{
    use HasFactory;

    protected $fillable = [
        'nickname', 'dob', 'gender', 'notes'
    ];

    public function appointments()
    {
        return $this->hasMany(
            Appointments::class,
            'patient_id'
        );
    }
}
