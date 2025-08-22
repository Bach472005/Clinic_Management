<?php

use App\Models\Patient;
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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(
                Patient::class, 
                'patient_id',    
            )->constrained('patients');

            $table->enum('marital_status', ['Độc thân', 'Đã kết hôn', 'Ly hôn', 'Khác']);
            $table->string('emergency_contact');
            $table->text('physical_history')->nullable();
            $table->text('medication_history')->nullable();
            $table->text('mental_history')->nullable();
            $table->text('family_mental_history')->nullable();
            $table->text('visit_reason')->nullable();
            $table->boolean('consent')->default(false); // Có/Không đồng ý

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
