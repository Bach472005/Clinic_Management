<?php

use App\Models\Appointment;
use App\Models\PaymentMethod;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount',10, 2);
            $table->enum('status', ['pending', 'paid', 'failed']);
            $table->timestamp('paid_at')->nullable();
            $table->foreignIdFor(
                Appointment::class,
                'appointment_id'
            )->constrained('appointments');
            $table->foreignIdFor(
                PaymentMethod::class,
                'method_id'
            )->constrained('payment_methods');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
