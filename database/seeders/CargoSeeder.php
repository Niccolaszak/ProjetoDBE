<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cargo')->insert([
            ['cargo' => 'Gerente',
             'salario' => 10000,
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['cargo' => 'Registrador',
             'salario' => 5000,
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['cargo' => 'Analista',
             'salario' => 7000,
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['cargo' => 'Estagiário',
             'salario' => 1300,
             'created_at' => now(),
             'updated_at' => now(),
            ],
        ]);
    }
}
