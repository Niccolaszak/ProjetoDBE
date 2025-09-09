<?php

return [
    [
        'nome' => 'Editar Permissões',
        'rotas' => ['permissoes.create', 'permissoes.store', 'permissoes.destroy']
    ],
    [
        'nome' => 'Consultar Permissões',
        'rotas' => ['permissoes.index']
    ],
    [
        'nome' => 'Registrar Usuários',
        'rotas' => ['register.store', 'register.create']
    ],
    [
        'nome' => 'Consultar Dashboard',
        'rotas' => ['dashboard']
    ],
    [
        'nome' => 'Consultar Painel',
        'rotas' => ['painel']
    ],
    [
        'nome' => 'Editar Perfil',
        'rotas' => ['profile.edit', 'profile.update', 'profile.destroy']
    ],
    [
        'nome' => 'Consultar Perfil',
        'rotas' => ['profile.index']
    ],
];