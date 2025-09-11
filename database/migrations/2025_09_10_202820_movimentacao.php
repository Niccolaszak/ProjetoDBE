<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimentacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('livro_id')->constrained('livros')->onDelete('cascade');
            $table->integer('quantidade');
            $table->string('tipo', 20); // "entrada" ou "saida"
            $table->string('responsavel', 100);
            $table->string('tipo_relacionamento', 20); // "fornecedor" ou "cliente"
            $table->foreignId('relacionamento_id')->nullable()->constrained('fornecedores')->nullOnDelete();
            $table->string('nome_contato', 150);
            $table->string('telefone_contato', 20);
            $table->timestamp('data_hora')->useCurrent();
            $table->text('observacao')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimentacoes');
    }
};
