<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cargo;

class CargoFactory extends Factory
{
    protected $model = Cargo::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->jobTitle,       // Ex: "Gerente", "Analista"
            'descricao' => $this->faker->sentence,   // Ex: "Responsável pelo setor financeiro"
        ];
    }
}