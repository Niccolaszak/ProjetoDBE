<?php

namespace App\Core\Users\Queries;

use App\Models\User;
use App\Models\Cargo;
use App\Models\Setor;

/**
 * Classe Query (CQRS) responsável por buscar e formatar
 * todos os dados para a tela de gerenciamento de Usuários.
 */
class ListarUsuariosQuery
{
    /**
     * Executa as consultas de listagem de usuários e
     * os dados de suporte (cargos, setores) para os formulários.
     *
     * @return array
     */
    public function handle(): array
    {
        // 1. Dados para a tabela principal de usuários
        // Otimização: Carrega 'cargo' e 'setor' e seleciona colunas
        // para evitar N+1 queries e reduzir o consumo de memória.
        $users = User::with('cargo:id,cargo', 'setor:id,setor')
            ->select('id', 'name', 'email', 'cargo_id', 'setor_id', 'forcar_redefinir_senha')
            ->get();

        // 2. Dados para os <select> dos formulários de create/edit
        $cargos = Cargo::select('id', 'cargo')->get();
        $setores = Setor::select('id', 'setor')->get();

        // 3. Formatação dos dados para os componentes <x-custom-select>
        $cargosOptions = $cargos->map(fn($cargo) => (object)[
            'id' => $cargo->id,
            'nome' => $cargo->cargo
        ]);

        $setoresOptions = $setores->map(fn($setor) => (object)[
            'id' => $setor->id,
            'nome' => $setor->setor
        ]);

        // Retorna todos os dados que a view 'users.index' precisa
        return compact(
            'users',
            'cargosOptions',
            'setoresOptions'
        );
    }
}