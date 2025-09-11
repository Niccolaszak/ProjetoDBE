<?php

return [
    [
        'nome' => 'Consultar Painel',
        'rotas' => ['painel']
    ],
    [
        'nome' => 'Editar Permissões',
        'rotas' => ['permissoes.store', 'permissoes.destroy', 'permissoes.index']
    ],
    [
        'nome' => 'Consultar Permissões',
        'rotas' => ['permissoes.index']
    ],
    [
        'nome' => 'Editar Usuários',
        'rotas' => ['users.update', 'users.destroy', 'users.index']
    ],
    [
        'nome' => 'Registrar Usuários',
        'rotas' => ['users.store', 'users.index']
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
        'rotas' => ['cargos.store', 'cargos.destroy', 'cargos.index']
    ],
    [
        'nome' => 'Consultar Cargos',
        'rotas' => ['cargos.index']
    ],
    [
        'nome' => 'Editar Setores',
        'rotas' => ['setores.store', 'setores.destroy', 'setores.index']
    ],
    [
        'nome' => 'Consultar Setores',
        'rotas' => ['setores.index']
    ],
    [
        'nome' => 'Consultar Livros',
        'rotas' => ['livros.index']
    ],
    [
        'nome' => 'Editar Livros',
        'rotas' => ['livros.index', 'livros.store', 'livros.update', 'livros.destroy']
    ],
    [
        'nome' => 'Consultar Generos',
        'rotas' => ['generos.index']
    ],
    [
        'nome' => 'Editar Generos',
        'rotas' => ['generos.index', 'generos.store', 'generos.destroy']
    ],
    [
        'nome' => 'Consultar Movimentações',
        'rotas' => ['movimentacoes.index']
    ],
    [
        'nome' => 'Editar Movimentações',
        'rotas' => ['movimentacoes.index', 'movimentacoes.store', 'movimentacoes.destroy']
    ],
    [
        'nome' => 'Consultar Estoque',
        'rotas' => ['estoques.index', 'estoques.show']
    ],
    [
        'nome' => 'Editar Fornecedores',
        'rotas' => ['fornecedores.index', 'fornecedores.store', 'fornecedores.destroy']
    ],
    [
        'nome' => 'Consultar Fornecedores',
        'rotas' => ['fornecedores.index']
    ],
];