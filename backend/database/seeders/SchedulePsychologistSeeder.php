<?php
namespace Database\Seeders;
use App\Models\Psychologist;
use Illuminate\Database\Seeder;
use App\Models\SchedulePsychologist;
use Carbon\Carbon;

class SchedulePsychologistSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy psychologist theo email của user
        $psychologist = Psychologist::whereHas('user', function ($query) {
            $query->where('email', 'psychologist@example.com');
        })->first();

        if (!$psychologist) {
            $this->command->warn("Không tìm thấy psychologist với email 'psychologist@example.com'. Bỏ qua seed.");
            return;
        }

        $psychologistId = $psychologist->id;
        $daysToGenerate = 7;

        for ($d = 0; $d < $daysToGenerate; $d++) {
            $date = Carbon::today()->addDays($d)->toDateString();

            for ($hour = 8; $hour < 11; $hour++) {
                foreach ([0, 30] as $minute) {
                    $startTime = sprintf('%02d:%02d:00', $hour, $minute);
                    $endMinute = $minute + 30;
                    $endHour = $hour;

                    if ($endMinute >= 60) {
                        $endMinute -= 60;
                        $endHour += 1;
                    }

                    $endTime = sprintf('%02d:%02d:00', $endHour, $endMinute);

                    SchedulePsychologist::create([
                        'psychologist_id' => $psychologistId,
                        'available_date' => $date,
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                        'is_booked' => false,
                    ]);
                }
            }
        }

        $this->command->info("✅ Đã tạo lịch cho psychologist ID: $psychologistId trong $daysToGenerate ngày.");
    }
}


