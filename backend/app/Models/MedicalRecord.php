<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'martial_status',
        'emergency_contact', 
        'physical_history', 
        'medication_history', 
        'mental_history', 
        'family_mental_history', 
        'visit_reason', 
        'consent'
    ];

    public function patient()
    {
        return $this->belongsTo(
            Patient::class,
            'patient_id'
        );
    }
}
