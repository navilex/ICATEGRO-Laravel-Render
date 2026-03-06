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
            $table->string('archivo_plan_estudios')->nullable();
            $table->string('archivo_becas')->nullable();
            $table->string('comentarios', 200)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grupos', function (Blueprint $table) {
            $table->dropColumn([
                'archivo_plan_estudios',
                'archivo_becas',
                'comentarios'
            ]);
        });
    }
};
