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
                'nome' => 'Desenvolvedor',
                'descricao' => 'Responsável por desenvolver e manter aplicações.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Analista de Sistemas',
                'descricao' => 'Analisa requisitos e sugere soluções tecnológicas.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Gerente de Projetos',
                'descricao' => 'Coordena equipes e garante entrega de projetos.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
