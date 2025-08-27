<?php

namespace App\Http\Controllers;

use App\Models\Psychologist;
use App\Models\SchedulePsychologist;
use Illuminate\Http\Request;

class SchedulePsychologistController extends Controller
{
    public function getAvailableSchedules(Psychologist $psychologist)
    {
        $schedules = SchedulePsychologist::where('psychologist_id', $psychologist->id)
            ->where('available_date', '>=', now()->toDateString())
            ->where('is_booked', false)
            ->orderBy('available_date')
            ->orderBy('start_time')
            ->get();

        return response()->json([
            'psychologist' => $psychologist,
            'schedule' => $schedules
        ]);
    }
}
