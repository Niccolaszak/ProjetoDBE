<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            CargoSeeder::class,
            FuncionarioSeeder::class,
            UsuarioSeeder::class,
            
            SetoresSeeder::class,
            CargosSeeder::class,
            TelaSeeder::class,
            AdminSeeder::class,
            GenerosSeeder::class,
            LivrosSeeder::class,
            FornecedoresSeeder::class,
            MovimentacoesSeeder::class,
        ]);
        // User::factory(10)->create();

        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/
    }
}