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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('cargo_id')->constrained('cargos');
            $table->string('cargo_nome');
            $table->foreignId('setor_id')->constrained('setores');
            $table->string('setor_nome');
            $table->decimal('salario', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['cargo_id']);
            $table->dropColumn(['cargo_id', 'cargo_nome']);
            $table->dropForeign(['setor_id']);
            $table->dropColumn(['setor_id', 'setor_nome']);
            $table->dropColumn(['salario']);
        });
    }
};
