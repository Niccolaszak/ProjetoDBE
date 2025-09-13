# ProjetoDBE
Repositorio para o projeto final de Desenvolvimento Back-End (DSWMII)

# Integrantes
1. Aline Brunetti
2. Nicolas Uczak
3. Vinicius Buskievicz

## Objetivo do Projeto

Sistema de gerenciamento de livraria, controlando livros, funcionários, cargos, movimentações e permissões de usuários, com foco em back-end robusto, seguro e escalável.

# Como rodar localHost

1. Ative o seu pacote de software de servidor local (usamos o WAMP)
2. Clone o repositório
3. Configure o .env para seu banco de dados (se houver, retire o .exemple do arquivo .env)
4. Com a pasta do projeto aberta no CMD rode
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

# Etapa 1 - 15/08

Foram criadas 5 tabelas principais para atender às funcionalidades do sistema:

- **genero**: contém `id` e `tipo` para padronizar e categorizar os livros por gênero literário, facilitando consultas e filtros.
- **cargo**: com `id`, `cargo` e `salário`, permitindo controlar permissões e níveis de acesso dos funcionários no sistema.
- **funcionario**: registra dados do colaborador (`id`, `nome`, `sobrenome`, `email`) e vincula ao cargo via `cargo_id`, essencial para controlar quem realiza as movimentações.
- **usuario**: armazena as credenciais de acesso (`login`, `senha`) associadas ao funcionário (`funcionario_id`), garantindo segurança no acesso ao sistema.
- **livro**: principal tabela que guarda informações sobre os livros (`titulo`, `autor`, `genero_id`, `quantidade_disponivel`) e registra movimentações importantes (`acao`, `responsavel_mov`, `data_hora`) para rastrear alterações no acervo.

Essa modelagem foi pensada para garantir organização, segurança no acesso e controle detalhado das movimentações, atendendo aos requisitos do sistema de gerenciamento de livraria.

- Para acessar a rota simples
   ```bash
   php artisan serve
   ```
   http://127.0.0.1:8000/hello-world

# Etapa 2 - 05/09

## Endpoints CRUD com Eloquent ORM
- Operações completas de **Create, Read, Update e Delete** implementadas para as principais entidades do projeto, incluindo:
  - **Livros** (com relacionamento a gêneros)
  - **Cargos** (com funcionários associados)
  - **Gêneros**, **Setores**, **Movimentações** e outros conforme necessidade
- Todas as operações interagem com o **banco de dados MySQL** via **Models** e **Controllers**
- Implementação de relacionamentos entre **Models**:
  - **Um-para-muitos** (ex: cargo → funcionários, gênero → livros)
  - **Muitos-para-muitos** quando aplicável (ex: movimentações relacionadas a múltiplos itens)
- Uso de **Seeders** para popular dados iniciais (ex: `MovimentacoesSeeder`)

## Sistema de Autenticação
- Registro e login de usuários implementados utilizando **Laravel Breeze**
- Hash de senhas garantido para segurança
- Restrição de acesso a rotas e funcionalidades para **usuários autenticados** utilizando **Middlewares**
- Cadastro de funcionários feito apenas por usuários autorizados
- No primeiro login, o usuário é obrigado a redefinir a senha
- Campos adicionais integrados ao registro de usuários:
  - **Cargo**, **Salário**, **Setor**
- Middleware `ForcarRedefinirSenha` implementado para garantir a redefinição de senha no primeiro acesso
- `SenhaController` e view `senha-redefinir.blade.php` implementados usando componentes do Breeze
- Controle de permissões para acesso a rotas e funcionalidades específicas (ex: apenas administradores podem cadastrar setores ou cargos)

## Validação de Dados de Entrada
- Todas as requisições CRUD possuem validação robusta utilizando as regras do **Laravel Request Validation**
- Validações incluem:
  - Tipos de dados (string, integer, float, date)
  - Limites de tamanho e caracteres
  - Campos obrigatórios e opcionais
  - Integridade referencial para relacionamentos
- Evita inconsistências e garante segurança na entrada de dados do sistema

## Frontend & Componentes
- Views criadas com **Blade Templates** e **componentes personalizados**:
  - Ex: `<x-custom-select>` para selects dinâmicos com dados do backend
  - Avisos de sucesso/erro via `<x-aviso>`
- Layouts responsivos e reutilizáveis, integrando **TailwindCSS**
- Implementação de **colapsáveis** para melhor organização visual
- Campos ocultos e inputs dinâmicos utilizados para transferir dados entre componentes

## Dashboard e Indicadores
- Dashboard com gráficos de estoque e movimentações utilizando **Chart.js**
- Cards de resumo para fácil visualização de métricas importantes
- Atualização dinâmica de informações via backend

## Movimentações e Estoque
- Controle completo de movimentações de entrada e saída de itens
- Regras para ajustar corretamente **quantidade disponível** e **quantidade consumida**:
  - Ex: ao excluir uma movimentação de saída, a quantidade disponível é ajustada corretamente
- Relacionamento com usuários responsáveis pelas movimentações

## Testes Automatizados
- Testes unitários implementados para:
  - Validação de dados
  - Funções auxiliares
  - Regras de negócio básicas
- Cobertura mínima de testes para endpoints críticos, garantindo estabilidade do sistema

## Observações e Boas Práticas
- Modelagem inicial adaptada para integração com o **Laravel Breeze**
- Apenas administradores podem criar contas de funcionários; não há auto-registro
- Após redefinição de senha, o usuário tem acesso completo ao dashboard e demais funcionalidades protegidas
- Boas práticas de Laravel aplicadas:
  - Uso de **Controllers**, **Models**, **Requests** e **Middlewares**
  - Estrutura de pastas organizada (`app/Models`, `app/Http/Controllers`, `resources/views`)
  - Uso de **Eloquent ORM** para manter consistência e legibilidade do código

