<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barbers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            
            $table->string('nickname');
            $table->string('photo')->nullable();
            $table->text('specialization')->nullable();        // Fade, Борода, Classic и т.д.
            $table->integer('experience_years')->nullable();
            $table->string('instagram')->nullable();
            $table->text('description')->nullable();
            
            // График работы (простой вариант)
            $table->json('working_days')->nullable();           // ["monday", "tuesday", ...]
            $table->time('start_time')->default('09:00:00');
            $table->time('end_time')->default('20:00:00');
            $table->integer('slot_duration_minutes')->default(30);   // длительность одного слота
            
            $table->integer('max_appointments_per_day')->default(12);
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barbers');
    }
};