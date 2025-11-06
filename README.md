# ProjetoDBE
Repositorio para o projeto final de Desenvolvimento Back-End (DSWMII)

# Integrantes
1. Aline Brunetti
2. Nicolas Uczak
3. Vinicius Buskievicz

## Objetivo do Projeto

Sistema de gerenciamento de livraria, controlando livros, funcionários, cargos, movimentações e permissões de usuários, com foco em back-end robusto, seguro e escalável.

# Como rodar localHost

1.  Ative o seu pacote de software de servidor local (usamos o WAMP).
2.  Clone o repositório.
3.  Configure o `.env` para seu banco de dados (se houver, retire o `.exemple` do arquivo `.env`).
4.  Com a pasta do projeto aberta no CMD rode:
    ```CMD
    composer install
    npm install
    ```
    **Observação sobre erros:**
    * Se o `npm install` falhar com um erro de `UnauthorizedAccess` ou "execução de scripts foi desabilitada", execute o VS Code (ou o CMD/PowerShell) como **Administrador** e tente novamente.
    * Se o `composer install` falhar com um erro sobre `bootstrap/cache`, crie manualmente a pasta `cache` dentro da pasta `bootstrap` e rode `composer install` novamente.

5.  Abra a pasta do projeto no VSCode para rodar as migrations e seeders:
    ```bash
    php artisan migrate:fresh --seed
    ```

6.  Crie a chave de criptografia da aplicação:
    ```bash
    php artisan key:generate
    ```

7.  No CMD rode:
    ```CMD
    npm run dev
    ```
    Depois no VsCode:
    ```bash
    php artisan serve
    ```
8. Primeiro acesso
  * Entre com `admin@admin.com` e senha `admin123`.

---

# Etapa 1 - 07/11

## Arquitetura, Padrões de Projeto e SOLID

O projeto foi reestruturado aplicando Padrões de Projeto (Design Patterns) e princípios SOLID para garantir um código limpo, manutenível, testável e escalável.

## 1. Padrão CQRS (Command Query Responsibility Segregation)

- **Objetivo:** Separar as operações de **Escrita (Commands)** das operações de **Leitura (Queries)**.

- **Demonstração:** O `LivroController` foi totalmente refatorado.

    - **Escrita (Commands):** As lógicas de `store`, `update` e `destroy` foram movidas do Controller para classes de *Handler* dedicadas (ex: `CreateLivroHandler`, `UpdateLivroHandler`, `DestroyLivroHandler`) localizadas em `app/Core/Livros/Handlers`. Os dados são transportados por *Commands* (DTOs) (ex: `CreateLivroCommand`) localizados em `app/Core/Livros/Commands`.

    - **Leitura (Queries):** A lógica de `index` (que busca livros e gêneros) foi movida para a classe `ListarLivrosQuery` em `app/Core/Livros/Queries`.
    
- **Princípio SOLID Aplicado:** **Single Responsibility Principle (S)**. O `LivroController` agora tem a única responsabilidade de lidar com a requisição HTTP (validação e resposta), enquanto os Handlers e Queries cuidam da lógica de negócio e acesso a dados.

## 2. Padrão Strategy

- **Objetivo:** Permitir que um algoritmo varie independentemente dos clientes que o utilizam.
- **Demonstração:** A lógica de movimentação de estoque foi desacoplada do `MovimentacaoController` e do model `Movimentacao`.
    - A lógica de `aplicarEstoque` e `reverterEstoque`, que antes estava no *Model*, foi movida para classes de Estratégia concretas: `EntradaStrategy` e `SaidaStrategy`, localizadas em `app/Domain/Movimentacao/Strategies`.
    - Ambas implementam a interface `MovimentacaoStrategy`.
    - Um `MovimentacaoContext` e um `MovimentacaoService` são usados para orquestrar e selecionar a estratégia correta (`entrada` ou `saida`) em tempo de execução.
- **Princípio SOLID Aplicado:** **Open/Closed Principle (O)**. O `MovimentacaoService` está *fechado para modificação*, mas *aberto para extensão*. Podemos adicionar novos tipos de movimentação (ex: `AjusteStrategy`) sem alterar o código do Service ou do Controller.

## 3. Padrão Factory Method

- **Objetivo:** Definir uma interface para criar um objeto, mas deixar a "fábrica" decidir qual classe concreta instanciar.
- **Demonstração:** Foi implementado um sistema de geração de relatórios de Livros (`PDF` e `CSV`), seguindo o exemplo de `ReportFactory`.
    - A `ReportFactory` (em `app/Domain/Reports/`) possui o método `createReport(string $type)` que centraliza a lógica de criação.
    - Baseado no `$type`, ela retorna uma instância de `LivroPdfReport` (usando `barryvdh/laravel-dompdf` e uma view Blade) ou `LivroCsvReport`.
    - Ambas as classes implementam a `ReportInterface`.
- **Princípio SOLID Aplicado:** O `ReportService` e o `ReportController` dependem da abstração (`ReportInterface`), não de implementações concretas, demonstrando o **Dependency Inversion Principle (D)**.

## 4. Injeção de Dependência (DI)

- **Demonstração:** O princípio de Inversão de Dependência foi aplicado em todas as refatorações usando o **Service Container** do Laravel.
    - Controllers recebem Services, Handlers e Queries via injeção no construtor ou no método (ex: `public function store(..., CreateLivroHandler $handler)`).
    - Services recebem suas dependências (ex: `ReportService` injeta `ReportFactory`).
    - Isso desacopla o código e o torna altamente testável.