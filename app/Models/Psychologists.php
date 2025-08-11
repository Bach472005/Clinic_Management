<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Psychologists extends Model
{
    use HasFactory;

    protected $fillable = [
        'specialization', 'bio', 'experience'
    ];

    public function appointments()
    {
        return $this->hasMany(
            Appointments::class,
            'psychologist_id'
        );
    }
}
