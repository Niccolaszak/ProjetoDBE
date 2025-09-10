<?php

return [
    [
        'nome' => 'Consultar Dashboard',
        'rotas' => ['dashboard']
    ],
    [
        'nome' => 'Consultar Painel',
        'rotas' => ['painel']
    ],
    [
        'nome' => 'Editar Permissões',
        'rotas' => ['permissoes.create', 'permissoes.store', 'permissoes.destroy']
    ],
    [
        'nome' => 'Consultar Permissões',
        'rotas' => ['permissoes.index']
    ],
    [
        'nome' => 'Editar Usuários',
        'rotas' => ['users.edit', 'users.update', 'users.destroy', 'users.index']
    ],
    [
        'nome' => 'Registrar Usuários',
        'rotas' => ['users.store', 'users.create']
    ],
    [
        'nome' => 'Consultar Usuários',
        'rotas' => ['users.index']
    ],
    [
        'nome' => 'Editar Perfil',
        'rotas' => ['profile.edit', 'profile.update', 'profile.destroy']
    ],
    [
        'nome' => 'Consultar Perfil',
        'rotas' => ['profile.index']
    ],
    [
        'nome' => 'Editar Cargos',
        'rotas' => ['cargos.create', 'cargos.store', 'cargos.destroy']
    ],
    [
        'nome' => 'Consultar Cargos',
        'rotas' => ['cargos.index']
    ],
    [
        'nome' => 'Editar Setores',
        'rotas' => ['setores.create', 'setores.store', 'setores.destroy']
    ],
    [
        'nome' => 'Consultar Setores',
        'rotas' => ['setores.index']
    ],
];