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
        Schema::create('grupo_instructor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grupo_id')->constrained('grupos')->onDelete('cascade');
            $table->foreignId('instructor_id')->constrained('instructors')->onDelete('cascade');
            $table->string('tipo');
            $table->date('fecha_inicio');
            $table->date('fecha_termino');
            $table->integer('duracion_dias');
            $table->integer('duracion_horas');
            $table->string('horario');
            $table->decimal('pago_instructor', 10, 2)->nullable();
            $table->date('fecha_pago')->nullable();
            $table->string('tipo_pago')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupo_instructor');
    }
};
