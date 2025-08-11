# ProjetoDBE
Repositorio para o projeto final de Desenvolvimento Back-End (DSWMII)

# Etapa 1 - 15/08

Foram criadas 5 tabelas principais para atender às funcionalidades do sistema:

- **genero**: contém `id` e `tipo` para padronizar e categorizar os livros por gênero literário, facilitando consultas e filtros.
- **cargo**: com `id`, `cargo` e `salário`, permitindo controlar permissões e níveis de acesso dos funcionários no sistema.
- **funcionario**: registra dados do colaborador (`id`, `nome`, `sobrenome`, `email`) e vincula ao cargo via `cargo_id`, essencial para controlar quem realiza as movimentações.
- **usuario**: armazena as credenciais de acesso (`login`, `senha`) associadas ao funcionário (`funcionario_id`), garantindo segurança no acesso ao sistema.
- **livro**: principal tabela que guarda informações sobre os livros (`titulo`, `autor`, `genero_id`, `quantidade_disponivel`) e registra movimentações importantes (`acao`, `responsavel_mov`, `data_hora`) para rastrear alterações no acervo.

Essa modelagem foi pensada para garantir organização, segurança no acesso e controle detalhado das movimentações, atendendo aos requisitos do sistema de gerenciamento de livraria.



    
    
