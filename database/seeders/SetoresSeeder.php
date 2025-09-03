<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SetoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('setores')->insert([
            [
                'nome' => 'Teste',
                'descricao' => 'Setor teste de factory',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Tecnologia',
                'descricao' => 'Responsável por toda a infraestrutura e desenvolvimento.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Recursos Humanos',
                'descricao' => 'Cuida da gestão de pessoas e processos internos.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Financeiro',
                'descricao' => 'Gerencia contas, pagamentos e orçamentos da empresa.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
