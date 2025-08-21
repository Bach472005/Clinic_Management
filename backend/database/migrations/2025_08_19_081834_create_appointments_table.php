<?php

use App\Models\Patient;
use App\Models\Psychologist;
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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->dateTime('schedule_time');
            $table->enum('method', ['offline', 'online'])->default('offline');
            $table->enum('status', ['pending', 'confirmed', 'canceled', 'completed'])->default('pending');
            $table->text('notes')->nullable()->comment('Internal notes');
            $table->unsignedInteger('version')->default(1);

            $table->foreignIdFor(
                User::class,
                'modified_id'
            )->nullable()->constrained('users');

            $table->foreignIdFor(
                Patient::class,
                'patient_id'
            )->constrained('patients');

            $table->foreignIdFor(
                Psychologist::class,
                'psychologist_id'
            )->constrained('psychologists');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
