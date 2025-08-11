<?php

use App\Models\Appointments;
use App\Models\Psychologists;
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
        Schema::create('therapy_notes', function (Blueprint $table) {
            $table->id();

            $table->text('content');
            $table->unsignedTinyInteger('session_number');

            $table->foreignIdFor(
                Psychologists::class
            )->constrained('psychologists');

            $table->foreignIdFor(
                Appointments::class
            )->constrained('appointments');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('therapy_notes');
    }
};
