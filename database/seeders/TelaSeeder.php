<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tela;

class TelaSeeder extends Seeder
{
    public function run(): void
    {
        $telas = config('telas');

        foreach ($telas as $t) {
            Tela::firstOrCreate(
                ['nome' => $t['nome']],
                ['rotas' => $t['rotas']]
            );
        }
    }
}