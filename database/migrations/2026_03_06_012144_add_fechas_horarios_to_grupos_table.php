<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('grupos', function (Blueprint $table) {
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_termino')->nullable();
            $table->integer('duracion_dias')->nullable();
            $table->integer('duracion_horas')->nullable();
            $table->integer('numero_semanas')->nullable();
            $table->integer('numero_horas_semana')->nullable();
            $table->text('horario')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grupos', function (Blueprint $table) {
            $table->dropColumn([
                'fecha_inicio',
                'fecha_termino',
                'duracion_dias',
                'duracion_horas',
                'numero_semanas',
                'numero_horas_semana',
                'horario'
            ]);
        });
    }
};
