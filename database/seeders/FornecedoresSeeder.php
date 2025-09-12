<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fornecedor;

class FornecedoresSeeder extends Seeder
{
    public function run(): void
    {
        $fornecedores = [
            [
                'tipo' => 'CNPJ',
                'razao_social' => 'Livraria Alpha Ltda',
                'cnpj_cpf' => '12.345.678/0001-90',
                'email' => 'contato@alpha.com',
                'telefone' => '11987654321',
                'endereco' => 'Rua das Letras, 123',
                'cidade' => 'São Paulo',
                'pais' => 'Brasil',
                'cep' => '01001-000',
                'pix' => 'alpha@pix.com',
                'conta_corrente' => '12345-6',
                'agencia' => '001',
            ],
            [
                'tipo' => 'CNPJ',
                'razao_social' => 'Editora Beta',
                'cnpj_cpf' => '98.765.432/0001-10',
                'email' => 'vendas@beta.com',
                'telefone' => '21987654321',
                'endereco' => 'Av. dos Livros, 456',
                'cidade' => 'Rio de Janeiro',
                'pais' => 'Brasil',
                'cep' => '20010-000',
                'pix' => 'beta@pix.com',
                'conta_corrente' => '65432-1',
                'agencia' => '002',
            ],
            [
                'tipo' => 'CNPJ',
                'razao_social' => 'Distribuidora Gama',
                'cnpj_cpf' => '11.222.333/0001-44',
                'email' => 'contato@gama.com',
                'telefone' => '31987654321',
                'endereco' => 'Rua do Saber, 789',
                'cidade' => 'Belo Horizonte',
                'pais' => 'Brasil',
                'cep' => '30110-000',
                'pix' => 'gama@pix.com',
                'conta_corrente' => '98765-4',
                'agencia' => '003',
            ],
            [
                'tipo' => 'CNPJ',
                'razao_social' => 'Livros Delta',
                'cnpj_cpf' => '55.666.777/0001-88',
                'email' => 'contato@delta.com',
                'telefone' => '41987654321',
                'endereco' => 'Av. Cultura, 321',
                'cidade' => 'Curitiba',
                'pais' => 'Brasil',
                'cep' => '80010-000',
                'pix' => 'delta@pix.com',
                'conta_corrente' => '11223-4',
                'agencia' => '004',
            ],
        ];

        foreach ($fornecedores as $fornecedor) {
            Fornecedor::create($fornecedor);
        }
    }
}