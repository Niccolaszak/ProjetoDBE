<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('usuario')->insert([
            [
                'login' => 'vinicius.gabriel',
                'senha' => '1234',
                'funcionario_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'login' => 'vinicius.buskievicz',
                'senha' => '1234',
                'funcionario_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'login' => 'aline.brunetti',
                'senha' => '1234',
                'funcionario_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'login' => 'nicolas.uczak',
                'senha' => '1234',
                'funcionario_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
