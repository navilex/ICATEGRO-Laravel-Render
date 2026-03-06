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
            $table->foreignId('plantel_id')->nullable()->constrained('planteles')->onDelete('set null');
            $table->string('estado')->nullable();
            $table->string('municipio')->nullable();
            $table->string('localidad')->nullable();
            $table->string('nombre_espacio')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grupos', function (Blueprint $table) {
            $table->dropForeign(['plantel_id']);
            $table->dropColumn([
                'plantel_id',
                'estado',
                'municipio',
                'localidad',
                'nombre_espacio'
            ]);
        });
    }
};
