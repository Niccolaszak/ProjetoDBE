<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Setor;

class SetorFactory extends Factory
{
    protected $model = Setor::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->word,           // Ex: "Financeiro", "RH"
            'descricao' => $this->faker->sentence,   // Ex: "Setor responsável por folha de pagamento"
        ];
    }
}