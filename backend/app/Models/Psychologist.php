<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Psychologist extends Model
{
    use HasFactory;

    protected $fillable = [
        'specialization', 'bio', 'experience', 'user_id'
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
            'psychologist_id'
        );
    }
}
