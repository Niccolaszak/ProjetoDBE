# Projeto Final - Desenvolvimento Back-End com PHP e Laravel

Este projeto é a aplicação final da disciplina de Desenvolvimento Back-End. O objetivo principal foi refatorar uma aplicação de gestão de livraria para aplicar conceitos avançados de arquitetura de software, padrões de projeto e segurança, demonstrando os conceitos aprendidos ao longo do semestre.

A aplicação foi reestruturada de um padrão MVC simples para uma arquitetura em camadas mais robusta e testável.

## Arquitetura e Padrões de Projeto Aplicados

[cite_start]Conforme solicitado no enunciado [cite: 1459-1464], o foco do projeto foi a aplicação correta e justificada de padrões de arquitetura e projeto.

### 1. Segurança: Policies e Gates (Fase 0)

A segurança foi implementada usando o sistema nativo de Autorização do Laravel (Gates e Policies), substituindo lógicas manuais.

* [cite_start]**Onde:** As permissões são carregadas dinamicamente no `app/Providers/AuthServiceProvider.php`[cite: 1497]. As regras de acesso para cada modelo (ex: `Livro`) são definidas em suas respectivas *Policies* (ex: `app/Policies/LivroPolicy.php`).
* [cite_start]**Justificativa:** Centraliza o controle de acesso, limpa os controllers (que agora usam `$this->authorizeResource(...)`) e segue as melhores práticas de segurança do framework[cite: 1529].

### 2. Repository Pattern (Fase 1)

Isolamos todo o acesso ao banco de dados da lógica de negócio, seguindo o Repository Pattern.

* **Onde:** Definimos "contratos" em `app/Interfaces` (ex: `LivroRepositoryInterface.php`) e criamos as implementações concretas em `app/Repositories` (ex: `EloquentLivroRepository.php`).
* [cite_start]**Justificativa:** Aplica o **Princípio da Inversão de Dependência (D do SOLID)**[cite: 1463]. Isso desacopla nossa aplicação do Eloquent, facilitando a manutenção e, crucialmente, permitindo a criação de testes unitários "mockados".

### 3. Service Layer (Fase 2)

Criámos uma camada de Serviço (`app/Services`) para conter todas as regras de negócio que antes estavam nos controllers.

* **Onde:** O `LivroService.php`, por exemplo, agora contém a lógica de negócio que impede a exclusão de um livro caso ele possua movimentações.
* [cite_start]**Justificativa:** Aplica o **Princípio da Responsabilidade Única (S do SOLID)**[cite: 1463]. Nossos controllers agora são "magros" (*thin controllers*); eles apenas orquestram as requisições HTTP e delegam o trabalho para os serviços.

### 4. Padrões Strategy e Factory Method (Fase 3)

[cite_start]Aplicamos os padrões **Strategy** e **Factory Method** para gerenciar a lógica complexa de criação de movimentações de estoque[cite: 1460, 1461].

* **Onde:** O `MovimentacaoService.php` não contém mais uma lógica `if/else` para 'entrada' ou 'saída'.
    1.  **Strategy:** Criamos as classes `ProcessaEntradaStrategy.php` e `ProcessaSaidaStrategy.php` em `app/Services/Strategies`. Cada uma contém a lógica específica (ex: verificar estoque na saída).
    2.  **Factory Method:** Criamos a `MovimentacaoStrategyFactory.php`, que tem um método `make()` responsável por instanciar a *Strategy* correta com base no tipo de movimentação.
* [cite_start]**Justificativa:** O `MovimentacaoService` agora obedece ao **Princípio Aberto/Fechado (O do SOLID)**[cite: 1463]. Podemos adicionar novos tipos de movimentação (como 'Devolução' ou 'Ajuste') apenas criando uma nova classe Strategy, sem nunca precisar alterar o `MovimentacaoService`.

### 5. CQRS (Command Query Responsibility Segregation) (Fase 4)

[cite_start]Refatoramos o `LivroController` para aplicar o padrão CQRS, separando completamente as operações de leitura (Queries) das de escrita (Commands)[cite: 1462].

* **Onde:** O `LivroController.php` foi totalmente modificado.
    * **Queries (Leitura):** O método `index()` agora chama um *Handler* dedicado (`app/Queries/Livro/ListarLivrosQueryHandler.php`), que busca os dados.
    * **Commands (Escrita):** Os métodos `store()` e `update()` agora criam DTOs (ex: `app/Commands/Livro/CriarLivroCommand.php`) e os "despacham" para *Handlers* de escrita (ex: `app/Commands/Livro/CriarLivroHandler.php`).
* **Justificativa:** O controller ficou extremamente limpo e focado. [cite_start]Este padrão permite que as lógicas de leitura sejam otimizadas de forma independente das lógicas de escrita, melhorando a manutenção e a performance do sistema[cite: 1493].

---

## Testes Automatizados

[cite_start]Para garantir a qualidade e a funcionalidade da nossa lógica de negócio, criamos testes unitários[cite: 1528].

* **Onde:** `tests/Unit/LivroServiceTest.php`.
* **Justificativa:** Este teste valida a regra de negócio mais crítica do `LivroService` (não excluir livro com movimentações). Graças ao Repository Pattern e à Injeção de Dependência, pudemos **"Mocar"** o repositório. O teste simula o repositório respondendo que "sim, existem movimentações" e valida se o `LivroService` corretamente lança uma exceção, provando que a lógica está isolada e correta.

---

## Como Executar o Projeto

1.  Clone o repositório:
    ```bash
    git clone [https://github.com/Niccolaszak/ProjetoDBE]
    ```
2.  Instale as dependências:
    ```bash
    composer install
    ```
3.  Configure seu arquivo `.env` (copie do `.env.example`) e informe os dados do seu banco de dados MySQL.

4.  Gere a chave da aplicação:
    ```bash
    php artisan key:generate
    ```
5.  Execute as migrações e popule o banco (Seeders):
    ```bash
    php artisan migrate --seed
    ```
6.  Inicie o servidor local:
    ```bash
    php artisan serve
    ```

---

## Autores

* [Aline Avila Brunetti]
* [Nicolas Miguel Uczak]
* [Vinicius Gabriel Buskievicz]