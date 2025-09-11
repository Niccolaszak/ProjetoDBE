<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\User;
use App\Models\Tela;
use App\Services\PermissaoService;
use Mockery;

class AcessoRegistroFuncionariosTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_usuario_com_permissao_pode_acessar_rota()
    {
        $user = new User(['cargo_id' => 5, 'setor_id' => 5]);
        $rota = 'users.store';

        // Mock do Permissao::whereHas(...)->exists() para simular que existe permissão
        $mock = Mockery::mock('alias:App\Models\Permissao');
        $mock->shouldReceive('whereHas->where->where->exists')
             ->andReturn(true);

        $service = new PermissaoService();

        $this->assertTrue($service->podeAcessarRota($user, $rota));
    }

    public function test_usuario_sem_permissao_nao_pode_acessar_rota()
    {
        $user = new User(['cargo_id' => 2, 'setor_id' => 2]);
        $rota = 'users.store';

        $mock = Mockery::mock('alias:App\Models\Permissao');
        $mock->shouldReceive('whereHas->where->where->exists')
             ->andReturn(false);

        $service = new PermissaoService();

        $this->assertFalse($service->podeAcessarRota($user, $rota));
    }
}
