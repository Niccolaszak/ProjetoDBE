<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CargosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cargos')->insert([
            [
                'nome' => 'Teste',
                'descricao' => 'Cargo teste de factory',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Gerente',
                'descricao' => 'Responsável por gerenciar um ou mais setores.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Especialista',
                'descricao' => 'Possui alto nível de conhecimento sobre o assunto.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Analista',
                'descricao' => 'Analisa e sugere soluções tecnológicas.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
