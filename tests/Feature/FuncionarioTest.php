<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class FuncionarioTest extends TestCase
{
    use RefreshDatabase;

    // ⚡ Aqui é onde colocamos o setUp
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function usuario_com_permissao_pode_abrir_a_tela_de_registro()
    {
        $user = User::factory()->create([
            'cargo_id' => 5,
            'setor_id' => 5
        ]);

        $response = $this->actingAs($user)->get(route('users.store'));

        $response->assertStatus(200);
        $response->assertSee('Registrar Funcionário');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function usuario_sem_permissao_nao_pode_abrir_a_tela_de_registro()
    {

        $user = User::factory()->create([
            'cargo_id' => 2, 
            'setor_id' => 2
        ]);

        $response = $this->actingAs($user)->get(route('users.store'));
        $response->assertStatus(403);
    }

}