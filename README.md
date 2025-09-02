# ProjetoDBE
Repositorio para o projeto final de Desenvolvimento Back-End (DSWMII)

# Integrantes
1. Aline Brunetti
2. Nicolas Uczak
3. Vinicius Buskievicz

# Instruções para rodar:
1. Ative o wamp
2. Crie um banco de dados GerenciamentoLivraria em phpmyadmin
3. Rode os comandos
   ```bash
   composer install
   php artisan migrate:fresh
   php artisan migrate:fresh --seed
   ```
4. Para acessar a rota simples
   ```bash
   php artisan serve
   ```
   http://127.0.0.1:8000/hello-world

# Etapa 1 - 15/08

Foram criadas 5 tabelas principais para atender às funcionalidades do sistema:

- **genero**: contém `id` e `tipo` para padronizar e categorizar os livros por gênero literário, facilitando consultas e filtros.
- **cargo**: com `id`, `cargo` e `salário`, permitindo controlar permissões e níveis de acesso dos funcionários no sistema.
- **funcionario**: registra dados do colaborador (`id`, `nome`, `sobrenome`, `email`) e vincula ao cargo via `cargo_id`, essencial para controlar quem realiza as movimentações.
- **usuario**: armazena as credenciais de acesso (`login`, `senha`) associadas ao funcionário (`funcionario_id`), garantindo segurança no acesso ao sistema.
- **livro**: principal tabela que guarda informações sobre os livros (`titulo`, `autor`, `genero_id`, `quantidade_disponivel`) e registra movimentações importantes (`acao`, `responsavel_mov`, `data_hora`) para rastrear alterações no acervo.

Essa modelagem foi pensada para garantir organização, segurança no acesso e controle detalhado das movimentações, atendendo aos requisitos do sistema de gerenciamento de livraria.

# Etapa 2 - 05/09

As tabelas usuario e funcionario não são mais utilizadas a partir desta etapa; elas permanecem existentes, com os dados inseridos na primeira fase, mas, para a continuidade coesa do projeto, será adotada a tabela de usuários fornecida pelo Breeze, integrada às tabelas cargos e setores.

Como o projeto destina-se ao gerenciamento interno de uma livraria, os funcionários não possuem permissão para se autoregistrar. Dessa forma, o cadastro é realizado por um usuário autorizado da plataforma, e, no primeiro login, o funcionário é obrigado a redefinir sua senha. Para consolidar o registro como efetivamente funcional, foram adicionados os campos cargo, salário e setor ao formulário de registro e à base de dados. O RegisteredUserController foi ajustado para persistir essas informações e atribuir uma senha temporária, o middleware ForcarRedefinirSenha garante que o usuário seja redirecionado à página de redefinição de senha no primeiro acesso, e o SenhaController, juntamente com a view senha-redefinir.blade.php, foi implementado utilizando os componentes do Breeze, assegurando que, após a redefinição da senha, o usuário tenha acesso ao dashboard e às demais funcionalidades protegidas da plataforma.
    
    
