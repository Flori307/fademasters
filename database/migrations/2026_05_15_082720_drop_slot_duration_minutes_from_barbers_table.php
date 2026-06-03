<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('barbers', function (Blueprint $table) {
            if (Schema::hasColumn('barbers', 'slot_duration_minutes')) {
                $table->dropColumn('slot_duration_minutes');
            }
        });
    }

    public function down()
    {
        Schema::table('barbers', function (Blueprint $table) {
            $table->integer('slot_duration_minutes')->default(30)->nullable();
        });
    }
};