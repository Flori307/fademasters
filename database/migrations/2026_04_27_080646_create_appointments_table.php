<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // клиент
            $table->foreignId('barber_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            
            $table->date('appointment_date');
            $table->time('start_time');
            $table->time('end_time');                    // будет рассчитываться автоматически
            
            $table->enum('status', [
                'pending', 
                'confirmed', 
                'completed', 
                'cancelled', 
                'no_show'
            ])->default('pending');
            
            $table->text('notes')->nullable();           // пожелания клиента (машинка 0, fade и т.д.)
            $table->timestamp('cancelled_at')->nullable();
            $table->string('cancelled_reason')->nullable();
            
            $table->timestamps();

            // Индексы для быстрых запросов
            $table->index(['barber_id', 'appointment_date', 'start_time']);
            $table->index(['user_id', 'appointment_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};