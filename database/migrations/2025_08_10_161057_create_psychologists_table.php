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
        Schema::create('psychologists', function (Blueprint $table) {
            $table->id();
            $table->string('specialization');
            $table->string('bio');
            $table->unsignedTinyInteger('experience');
            $table->unsignedInteger('version')->default(1);

            $table->foreignIdFor(
                User::class,
                'user_id'
            )->constrained('users');
            $table->foreignIdFor(
                User::class,
                'modified_id'
            )->nullable()->constrained('users');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psychologists');
    }
};
