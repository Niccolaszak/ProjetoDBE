<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->id();
            $table->string('tipo', 50); // Ex: "Pessoa Física" ou "Pessoa Jurídica"
            $table->string('razao_social', 150);
            $table->string('cnpj_cpf', 20)->unique();
            $table->string('email', 100);
            $table->string('telefone', 20);
            $table->string('endereco', 150);
            $table->string('cidade', 100);
            $table->string('pais', 50);
            $table->string('cep', 10);
            $table->string('pix', 100);
            $table->string('conta_corrente', 50);
            $table->string('agencia', 20);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fornecedores');
    }
};