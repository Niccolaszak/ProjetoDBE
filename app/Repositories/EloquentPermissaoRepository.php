<?php

namespace App\Repositories;

use App\Interfaces\PermissaoRepositoryInterface;
use App\Models\Permissao;
use Illuminate\Database\Eloquent\Collection;

/**
 * Implementação Eloquent do PermissaoRepositoryInterface.
 */
class EloquentPermissaoRepository implements PermissaoRepositoryInterface
{
    /**
     * Retorna todas as permissões (exceto de Admin) com suas relações.
     */
    public function getPermissoesComRelacoes(): Collection
    {
        return Permissao::with(['tela', 'cargo', 'setor'])
            ->whereHas('cargo', function($q) {
                    $q->where('nome', '!=', 'Admin');
                })
            ->get();
    }

    /**
     * Cria uma nova permissão.
     */
    public function create(array $data): Permissao
    {
        return Permissao::create($data);
    }

    /**
     * Exclui uma permissão.
     */
    public function delete(Permissao $permissao): ?bool
    {
        return $permissao->delete();
    }
}