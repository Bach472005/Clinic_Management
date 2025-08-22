<?php

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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('nickname', 255)->nullable();
            $table->date('dob');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->text('notes')->nullable();
            $table->text('address');
            $table->string('occupation')->nullable();
            $table->foreignIdFor(
                User::class,
                'user_id'
            )->constrained('users');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
