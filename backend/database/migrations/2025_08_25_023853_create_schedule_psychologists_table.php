<?php

use App\Models\Psychologist;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedule_psychologists', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Psychologist::class, 'psychologist_id')->constrained('psychologists');
            $table->date('available_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('is_booked')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['schedule_id']);
        });
        Schema::dropIfExists('schedule_psychologists');
    }
};
