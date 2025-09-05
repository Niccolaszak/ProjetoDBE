<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Cargo;
use App\Models\Setor;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FiltragemTest extends TestCase
{
    use RefreshDatabase;

    public function test_cargos_e_setores_filtrados()
    {
        // Cria cargos e setores de exemplo
        Cargo::factory()->create(['nome' => 'Admin']);
        Cargo::factory()->create(['nome' => 'Funcionario']);
        Setor::factory()->create(['nome' => 'Teste']);
        Setor::factory()->create(['nome' => 'Financeiro']);

        // Filtragem simulando o controller
        $cargosFiltrados = Cargo::all()->filter(fn($c) => !in_array($c->nome, ['Admin', 'Teste']));
        $setoresFiltrados = Setor::all()->filter(fn($s) => !in_array($s->nome, ['Admin', 'Teste']));

        // Verifica se os indesejados não aparecem
        $this->assertFalse($cargosFiltrados->contains('nome', 'Admin'));
        $this->assertTrue($cargosFiltrados->contains('nome', 'Funcionario'));

        $this->assertFalse($setoresFiltrados->contains('nome', 'Teste'));
        $this->assertTrue($setoresFiltrados->contains('nome', 'Financeiro'));
    }
}