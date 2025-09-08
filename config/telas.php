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
        'nome' => 'Editar Perfil',
        'rotas' => ['profile.update', 'profile.destroy']
    ],
    [
        'nome' => 'Consultar Perfil',
        'rotas' => ['profile.edit']
    ],
    [
        'nome' => 'Editar Registro de Usuários',
        'rotas' => ['register.store']
    ],
    [
        'nome' => 'Consultar Registro de Usuários',
        'rotas' => ['register.create']
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
        'nome' => 'Editar Senha',
        'rotas' => ['senha.redefinir', 'senha.redefinir.update', 'password.update', 'password.store']
    ],
    [
        'nome' => 'Consultar Senha',
        'rotas' => ['password.request', 'password.reset', 'password.email', 'verification.send', 'verification.notice', 'verification.verify', 'confirm-password', 'password.confirm']
    ],
    [
        'nome' => 'Consultar Hello World',
        'rotas' => ['hello-world']
    ],
    [
        'nome' => 'Acesso Logout',
        'rotas' => ['logout']
    ],
    [
        'nome' => 'Acesso Storage',
        'rotas' => ['storage.local']
    ],
    [
        'nome' => 'Acesso Up',
        'rotas' => ['up']
    ],
];