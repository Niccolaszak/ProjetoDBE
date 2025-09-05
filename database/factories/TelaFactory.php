<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tela;

class TelaFactory extends Factory
{
    protected $model = Tela::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->words(2, true),   // Ex: "Dashboard Principal", "Cadastrar Livros"
            'rota' => $this->faker->unique()->slug,   // Ex: "dashboard-principal", "cadastrar-livros"
        ];
    }
}