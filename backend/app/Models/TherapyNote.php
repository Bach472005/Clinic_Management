<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TherapyNote extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'content', 'session_number'
    ];

    public function therapyNoteLogs()
    {
        return $this->hasMany(
            TherapyNoteLog::class
        );
    }
}
