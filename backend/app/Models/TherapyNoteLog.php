<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TherapyNoteLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'content', 'session_number'
    ];

    public function therapyNote()
    {
        return $this->belongsTo(
            TherapyNote::class
        );
    }
}
