<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Livro;
use App\Services\LivroService;
use App\Interfaces\LivroRepositoryInterface;
use Mockery;
use Mockery\MockInterface;
use Exception;

/**
 * Teste de Unidade para o LivroService.
 * Foco: Testar a lógica de negócio, não o banco de dados.
 */
class LivroServiceTest extends TestCase
{
    /**
     * @var LivroRepositoryInterface|MockInterface
     */
    private $livroRepositoryMock;
    private LivroService $livroService;
    private Livro $livroMock;

    /**
     * Configura o ambiente de teste antes de cada método.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // 1. Criamos "Mocks" (simulações) dos nossos objetos.
        $this->livroRepositoryMock = Mockery::mock(LivroRepositoryInterface::class);
        $this->livroMock = Mockery::mock(Livro::class);

        // 2. Injetamos o Repositório FALSO no Service VERDADEIRO.
        $this->livroService = new LivroService($this->livroRepositoryMock);
    }

    /**
     * Garante que o Mockery seja limpo após cada teste.
     */
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    // -----------------------------------------------------------------
    // OS TESTES
    // -----------------------------------------------------------------

    /**
     * Teste (Cenário de Falha): Tenta excluir um livro que TEM movimentações.
     *
     * @test
     */
    public function test_excluir_livro_com_movimentacoes_deve_lancar_excecao()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Não é possível excluir este livro, pois existem movimentações vinculadas.');

        $this->livroRepositoryMock
            ->shouldReceive('hasMovimentacoes')
            ->once()
            ->with($this->livroMock)
            ->andReturn(true);

        // "Garantimos que o método 'delete' NUNCA será chamado."
        $this->livroRepositoryMock
            ->shouldNotReceive('delete');

        $this->livroService->excluirLivro($this->livroMock);
    }

    /**
     * Teste (Cenário de Sucesso): Tenta excluir um livro que NÃO TEM movimentações.
     *
     * @test
     */
    public function test_excluir_livro_sem_movimentacoes_deve_ter_sucesso()
    {
        
        // "Quando o método 'hasMovimentacoes' for chamado, RETORNE 'false'."
        $this->livroRepositoryMock
            ->shouldReceive('hasMovimentacoes')
            ->once()
            ->with($this->livroMock)
            ->andReturn(false);

        // "Quando o método 'delete' for chamado, RETORNE 'true'."
        $this->livroRepositoryMock
            ->shouldReceive('delete')
            ->once()
            ->with($this->livroMock)
            ->andReturn(true);

        $resultado = $this->livroService->excluirLivro($this->livroMock);

        $this->assertTrue($resultado);
    }
}