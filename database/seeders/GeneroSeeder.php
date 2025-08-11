<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeneroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('genero')->insert([
            [
                'categoria' => 'Ficção',
                'descricao_categoria' => 'Livros que contêm histórias inventadas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoria' => 'Romance',
                'descricao_categoria' => 'Histórias focadas em relacionamentos amorosos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoria' => 'Fantasia',
                'descricao_categoria' => 'Narrativas com elementos mágicos ou sobrenaturais',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoria' => 'Mistério',
                'descricao_categoria' => 'Histórias envolvendo crimes ou enigmas a serem resolvidos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoria' => 'Histórico',
                'descricao_categoria' => 'Livros que se passam em períodos históricos reais',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoria' => 'Biografia',
                'descricao_categoria' => 'Relatos da vida de pessoas reais',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoria' => 'Autoajuda',
                'descricao_categoria' => 'Livros com dicas para desenvolvimento pessoal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoria' => 'Ciência',
                'descricao_categoria' => 'Livros que abordam temas científicos e acadêmicos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
