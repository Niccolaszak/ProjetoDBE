<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Livro;
use App\Models\Genero;

class LivrosSeeder extends Seeder
{
    public function run(): void
    {
        $livros = [
            ['titulo' => 'Duna', 'autor' => 'Frank Herbert', 'genero_id' => 1, 'descricao_livro' => 'Clássico da ficção científica.'],
            ['titulo' => 'Neuromancer', 'autor' => 'William Gibson', 'genero_id' => 1, 'descricao_livro' => 'Ciberpunk e inteligência artificial.'],
            ['titulo' => 'Orgulho e Preconceito', 'autor' => 'Jane Austen', 'genero_id' => 2, 'descricao_livro' => 'Romance clássico.'],
            ['titulo' => 'O Morro dos Ventos Uivantes', 'autor' => 'Emily Brontë', 'genero_id' => 2, 'descricao_livro' => 'Romance trágico.'],
            ['titulo' => 'Sherlock Holmes', 'autor' => 'Arthur Conan Doyle', 'genero_id' => 3, 'descricao_livro' => 'Mistérios e detetives.'],
            ['titulo' => 'O Código Da Vinci', 'autor' => 'Dan Brown', 'genero_id' => 3, 'descricao_livro' => 'Mistério e conspiração.'],
            ['titulo' => 'Sapiens', 'autor' => 'Yuval Noah Harari', 'genero_id' => 4, 'descricao_livro' => 'História da humanidade.'],
            ['titulo' => 'Guerra e Paz', 'autor' => 'Liev Tolstói', 'genero_id' => 4, 'descricao_livro' => 'Romance histórico.'],
            ['titulo' => 'Steve Jobs', 'autor' => 'Walter Isaacson', 'genero_id' => 5, 'descricao_livro' => 'Biografia do fundador da Apple.'],
            ['titulo' => 'Becoming', 'autor' => 'Michelle Obama', 'genero_id' => 5, 'descricao_livro' => 'Autobiografia inspiradora.'],
        ];

        foreach ($livros as $l) {
            Livro::create($l);
        }
    }
}