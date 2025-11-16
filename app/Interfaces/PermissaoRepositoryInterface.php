<?php

namespace App\Interfaces;

use App\Models\Permissao;
use Illuminate\Database\Eloquent\Collection;

/**
 * Define o contrato para o repositório de Permissões.
 */
interface PermissaoRepositoryInterface
{
    /**
     * Retorna todas as permissões (exceto de Admin) com suas relações.
     *
     * @return Collection
     */
    public function getPermissoesComRelacoes(): Collection;

    /**
     * Cria uma nova permissão.
     *
     * @param array $data
     * @return Permissao
     */
    public function create(array $data): Permissao;

    /**
     * Exclui uma permissão.
     *
     * @param Permissao $permissao
     * @return bool|null
     */
    public function delete(Permissao $permissao): ?bool;
}