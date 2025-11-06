<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movimentacao;
use App\Models\Livro;
use App\Models\Fornecedor;
use App\Services\MovimentacaoService; 

class MovimentacoesSeeder extends Seeder
{
    public function run(): void
    {
        $service = resolve(MovimentacaoService::class);

        $livros = Livro::all();
        $fornecedores = Fornecedor::all();

        // --- ENTRADAS INICIAIS ---
        foreach ($livros as $livro) {
            $mov = Movimentacao::create([
                'livro_id' => $livro->id,
                'quantidade' => rand(5, 15),
                'tipo' => 'entrada',
                'responsavel' => "admin",
                'tipo_relacionamento' => 'fornecedor',
                'relacionamento_id' => $fornecedores->random()->id,
                'nome_contato' => 'Fornecedor Inicial',
                'telefone_contato' => '119' . rand(10000000, 99999999),
                'observacao' => 'Entrada inicial de estoque para o livro ' . $livro->titulo,
                'data_hora' => now()->subDays(rand(10, 30)),
            ]);

            $service->processar($mov);
        }

        // --- MOVIMENTAÇÕES ALEATÓRIAS ---
        for ($i = 0; $i < 20; $i++) {
            $isEntrada = rand(0, 1) === 1;
            $livro = $livros->random();

            if ($isEntrada) {
                // LÓGICA DE ENTRADA
                $mov = Movimentacao::create([
                    'livro_id' => $livro->id,
                    'quantidade' => rand(1, 5),
                    'tipo' => 'entrada',
                    'responsavel' => "admin",
                    'tipo_relacionamento' => 'fornecedor',
                    'relacionamento_id' => $fornecedores->random()->id,
                    'nome_contato' => 'Fornecedor ' . rand(1, 100),
                    'telefone_contato' => '9' . rand(100000000, 999999999),
                    'observacao' => 'Reposição de estoque',
                    'data_hora' => now()->subDays(rand(0, 9)),
                ]);

                $service->processar($mov);

            } else {
                // LÓGICA DE SAÍDA
                
                try {
                    // Simula uma quantidade de saída
                    $qtd = rand(1, 3);

                    $mov = Movimentacao::create([
                        'livro_id' => $livro->id,
                        'quantidade' => $qtd,
                        'tipo' => 'saida',
                        'responsavel' => "admin",
                        'tipo_relacionamento' => 'cliente',
                        'relacionamento_id' => null,
                        'nome_contato' => 'Cliente ' . rand(1, 100),
                        'telefone_contato' => '9' . rand(100000000, 999999999),
                        'observacao' => 'Venda de livro',
                        'data_hora' => now()->subDays(rand(0, 9)),
                    ]);

                    // 3. Processar a movimentação
                    $service->processar($mov);

                } catch (\Exception $e) {
                }
            }
        }
    }
}