<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Permissao;
use App\Models\Tela;
use App\Models\Cargo;
use App\Models\Setor;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PermissaoTest extends TestCase
{
    use RefreshDatabase;

    public function test_criar_permissao_valida()
    {
        $this->withoutMiddleware(); // ignora todos os middlewares

        // Criar dados de exemplo
        $tela = Tela::factory()->create();
        $cargo = Cargo::factory()->create();
        $setor = Setor::factory()->create();
        $user = \App\Models\User::factory()->create([
            'cargo_id' => $cargo->id,
            'setor_id' => $setor->id,
        ]);

        $this->actingAs($user);

        // Post para criar permissão
        $response = $this->post(route('permissoes.store'), [
            'tela_id' => $tela->id,
            'cargo_id' => $cargo->id,
            'setor_id' => $setor->id,
        ]);

        // Verifica redirecionamento
        $response->assertRedirect(route('permissoes.index'));

        // Verifica se foi criado no banco
        $this->assertDatabaseHas('permissoes', [
            'tela_id' => $tela->id,
            'cargo_id' => $cargo->id,
            'setor_id' => $setor->id,
        ]);
    }
}
