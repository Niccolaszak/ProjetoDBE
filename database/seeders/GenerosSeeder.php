<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genero;

class GenerosSeeder extends Seeder
{
    public function run(): void
    {
        $generos = [
            ['genero' => 'Ficção Científica', 'descricao_genero' => 'Livros de ficção científica e fantasia futurista.'],
            ['genero' => 'Romance', 'descricao_genero' => 'Histórias de amor e relacionamentos.'],
            ['genero' => 'Mistério', 'descricao_genero' => 'Livros de suspense e mistério.'],
            ['genero' => 'Histórico', 'descricao_genero' => 'Livros baseados em acontecimentos históricos.'],
            ['genero' => 'Biografia', 'descricao_genero' => 'Histórias da vida real de pessoas importantes.'],
        ];

        foreach ($generos as $g) {
            Genero::create($g);
        }
    }
}