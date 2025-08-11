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
        //id,titulo, autor, genero_fk, quantidade_disponivel, acao, data_hora
        Schema::create('livro', function(Blueprint $table){
            $table->id();
            $table->string('titulo', 100);
            $table->string('autor', 100);
            $table->foreignId('genero_id')->constrained('genero');
            $table->integer('quantidade_disponivel')->default(0);
            $table->string('acao', 50);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
