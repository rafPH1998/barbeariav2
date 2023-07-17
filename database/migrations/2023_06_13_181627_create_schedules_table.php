<?php

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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete("CASCADE");
            $table->date('date');
            $table->string('end_service')->nullable();
            $table->string('hour');
            $table->integer('price')->nullable();
            $table->enum('status', ['pendente', 'cancelado', 'finalizado']);
            $table->enum('service', ['corte', 'corte_barba']);
            $table->string('barber');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
