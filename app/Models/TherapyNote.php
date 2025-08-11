<?php

namespace App\Models;

use App\Models\TherapyNoteLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
