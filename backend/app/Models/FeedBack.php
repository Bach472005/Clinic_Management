<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedBack extends Model
{
    use HasFactory;

    protected $fillable = [
        'rating', 'comment', 'created_at'
    ];

    public function appointment()
    {
        return $this->belongsTo(
            Appointment::class
        );
    }
}
