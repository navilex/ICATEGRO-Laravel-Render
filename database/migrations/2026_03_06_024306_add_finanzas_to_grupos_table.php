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
            $table->string('tipo_pago_grupo')->nullable();
            $table->decimal('costo_por_persona', 10, 2)->default(0);
            $table->decimal('costo_por_grupo', 10, 2)->default(0);
            $table->decimal('costo_coffee_break', 10, 2)->default(0);
            $table->decimal('ingreso_total', 10, 2)->default(0);
            $table->decimal('utilidad_grupo', 10, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grupos', function (Blueprint $table) {
            $table->dropColumn([
                'tipo_pago_grupo',
                'costo_por_persona',
                'costo_por_grupo',
                'costo_coffee_break',
                'ingreso_total',
                'utilidad_grupo'
            ]);
        });
    }
};
