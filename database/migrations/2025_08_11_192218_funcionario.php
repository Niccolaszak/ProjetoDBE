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
        Schema::create('funcionario', function(Blueprint $table){
            $table->id();
            $table->string('nome', 100);
            $table->string('sobrenome', 100);
            $table->string('email', 100)->unique();
            $table->foreignId('cargo_id')->constrained('cargo');
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
