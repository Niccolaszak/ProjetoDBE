# Gerenciamento Livraria
Um projeto laravel completo para o gerenciamento de uma livraria. Comporta o gerenciamento de usuários, cargos, setores, permissões, gêneros de livros, movimentações, estoque, fornecedores.

Feito originalmente para um trabalho de faculdade, repositório original pode ser consultado em:
```link
https://github.com/Niccolaszak/ProjetoDBE
```

# Como rodar localHost
1. clone o repositório
2. configure o .env para seu banco de dados (se houver, retire o .exemple do arquivo .env)
4.  Com a pasta do projeto aberta no CMD rode
     ```CMD
     composer install
     npm install
     ```
     Se der erro, tente entrar no CMD como administrador
     ou
     Entregue permissão para edição da pasta pelo CMD
     ```CMD
     icacls "C:\Caminho\da\Pasta" /grant Todos:(OI)(CI)F /T /C
     ```

5. Abra a pasta do projeto no VSCode para rodar as migrations e seeders
     ```bash
     php artisan migrate:fresh --seed
     ```

6. Crie a chave de criptografia da aplicação
     ```bash
     php artisan key:generate
     ```

7. No CMD rode
    ```CMD
    npm run dev
    ```
    Depois no VsCode
    ```bash
     php artisan serve
     ```
# Primeiro acesso
1. Entre com admin@admin.com e senha admin123
2. Agora é só se divertir, descobrir o que faz o que e moldar o projeto para você

# Alterações 
1. Telas
   O gerênciamento das telas é feito por meio do arquivo config/telas.php"
