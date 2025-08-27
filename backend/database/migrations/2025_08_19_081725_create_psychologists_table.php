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
    public function up()
    {
        Schema::create('psychologists', function (Blueprint $table) {
            $table->id();
            
            $table->string('specialization');
            $table->text('bio');
            $table->unsignedTinyInteger('experience');

            // 🔽 Trường mới được thêm
            $table->string('education')->nullable();
            $table->string('method')->nullable();
            $table->text('focus_areas')->nullable();
            $table->string('image_url')->nullable(); // URL ảnh bác sĩ

            $table->foreignIdFor(User::class, 'user_id')->constrained('users');

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
