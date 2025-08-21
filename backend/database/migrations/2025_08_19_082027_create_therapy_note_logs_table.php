<?php

use App\Models\Appointment;
use App\Models\Psychologist;
use App\Models\TherapyNote;
use App\Models\User;
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
        Schema::create('therapy_note_logs', function (Blueprint $table) {
            $table->id();

            $table->text('content');
            $table->unsignedTinyInteger('session_number');

            $table->foreignIdFor(
                TherapyNote::class,
                'therapy_note_id'
            )->constrained('therapy_notes');

            $table->foreignIdFor(
                Psychologist::class
            )->constrained('psychologists');

            $table->foreignIdFor(
                Appointment::class
            )->constrained('appointments');

            $table->foreignIdFor(
                User::class,
                'modified_id'
            )->constrained('users');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('therapy_note_logs');
    }
};
