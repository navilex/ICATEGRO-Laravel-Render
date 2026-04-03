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
        Schema::table('lista_cursos_alumnos', function (Blueprint $table) {
            $table->json('grupos_vulnerables')->nullable()->after('group_id');
            $table->json('discapacidades')->nullable()->after('grupos_vulnerables');
            $table->string('escolaridad')->nullable()->after('discapacidades');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lista_cursos_alumnos', function (Blueprint $table) {
            $table->dropColumn(['grupos_vulnerables', 'discapacidades', 'escolaridad']);
        });
    }
};
