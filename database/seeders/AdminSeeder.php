<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Tela;
use App\Models\Permissao;
use App\Models\Cargo;
use App\Models\Setor;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $cargo = Cargo::firstOrCreate(['nome' => 'Admin'], ['descricao' => 'Administrador do sistema']);
        $setor = Setor::firstOrCreate(['nome' => 'Admin'], ['descricao' => 'Administrador do sistema']);

        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'admin',
                'password' => Hash::make('admin123'), // senha padrão
                'cargo_id' => $cargo->id,
                'setor_id' => $setor->id,
                'cargo_nome' => $cargo->nome,
                'setor_nome' => $setor->nome,
                'salario' => 0.00,
                'forcar_redefinir_senha' => false,
            ]
        );
        
        $todasTelas = Tela::all();
        foreach ($todasTelas as $tela) {
            Permissao::firstOrCreate([
                'tela_id' => $tela->id,
                'cargo_id' => $cargo->id,
                'setor_id' => $setor->id,
            ]);
        }
    }
}
