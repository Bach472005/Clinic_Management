<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\SchedulePsychologist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedule_psychologists,id',
            'method' => 'required|in:offline,online',
            'notes' => 'nullable|string',
            'patient_id' => 'required|exists:patients,id',
        ]);

        $schedule = SchedulePsychologist::where('id', $request->schedule_id)
            ->where('is_booked', false)
            ->first();

        if (!$schedule) {
            return response()->json(['message' => 'Lịch hẹn không khả dụng'], 409);
        }

        DB::beginTransaction();
        try {
            $appointment = Appointment::create([
                'schedule_id' => $schedule->id,
                'psychologist_id' => $schedule->psychologist_id,
                'patient_id' => $request->patient_id,
                'method' => $request->input('method'),
                'notes' => $request->notes,
                'modified_id' => auth()->check() ? auth()->id() : null,
            ]);

            $schedule->is_booked = true;
            $schedule->save();

            DB::commit();
            return response()->json($appointment, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Đã xảy ra lỗi khi tạo lịch hẹn'], 500);
        }
    }
}
