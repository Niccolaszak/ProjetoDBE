<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FuncionarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('funcionario')->insert([
            [
                'nome' => 'Aline',
                'sobrenome' => 'Brunetti',
                'email' => 'aline.brunetti@livraria.com',
                'cargo_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Nicolas',
                'sobrenome' => 'Uczak',
                'email' => 'nicolas.uczak@livraria.com',
                'cargo_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Vinicius',
                'sobrenome' => 'Buskievicz',
                'email' => 'vinicius.buskievicz@livraria.com',
                'cargo_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Vinicius',
                'sobrenome' => 'Gabriel',
                'email' => 'vinicius.gabriel@livraria.com',
                'cargo_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
