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
        Schema::create('grupos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_servicio');
            $table->string('modalidad_ce')->nullable();
            $table->string('modalidad');
            $table->foreignId('oferta_educativa_id')->constrained('oferta_educativas')->onDelete('cascade');
            $table->foreignId('campo_formacion_id')->constrained('campo_formacions')->onDelete('cascade');
            $table->foreignId('especialidad_ocupacional_id')->constrained('especialidad_ocupacionals')->onDelete('cascade');
            $table->foreignId('curso_id')->nullable()->constrained('cursos')->onDelete('cascade');
            $table->foreignId('curso_icategro_id')->nullable()->constrained('curso_icategros')->onDelete('cascade');
            $table->integer('alumnos_inician');
            $table->integer('capacidad_maxima');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupos');
    }
};
