<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');      // кто оставил
            $table->foreignId('barber_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('appointment_id')->nullable()->constrained()->onDelete('set null');
            
            $table->tinyInteger('rating')->unsigned()->comment('1-5');
            $table->text('comment');
            $table->boolean('is_approved')->default(false);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};