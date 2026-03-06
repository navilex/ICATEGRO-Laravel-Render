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
        Schema::create('grupo_calendarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grupo_id')->constrained('grupos')->onDelete('cascade');
            $table->string('tipo_fecha'); // DÍA o SEMANA
            $table->date('fecha_inicial');
            $table->date('fecha_final')->nullable();
            $table->time('hora_inicial');
            $table->time('hora_final');
            $table->integer('total_dias');
            $table->decimal('total_horas', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupo_calendarios');
    }
};
