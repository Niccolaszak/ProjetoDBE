<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Tela;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Exception;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * O mapeamento de policies para os modelos da aplicação.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \App\Models\Cargo::class => \App\Policies\CargoPolicy::class,
        \App\Models\Estoque::class => \App\Policies\EstoquePolicy::class,
        \App\Models\Fornecedor::class => \App\Policies\FornecedorPolicy::class,
        \App\Models\Genero::class => \App\Policies\GeneroPolicy::class,
        \App\Models\Livro::class => \App\Policies\LivroPolicy::class,
        \App\Models\Movimentacao::class => \App\Policies\MovimentacaoPolicy::class,
        \App\Models\Permissao::class => \App\Policies\PermissaoPolicy::class,
        \App\Models\Setor::class => \App\Policies\SetorPolicy::class,
        \App\Models\User::class => \App\Policies\UserPolicy::class,
    ];

    /**
     * Registra qualquer serviço de autenticação / autorização.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        /**
         * Define o "Super Administrador"
         */
        Gate::before(function (User $user, string $ability) {
            // strcasecmp retorna 0 se as strings forem iguais, ignorando maiúsculas/minúsculas.
            if (strcasecmp($user->cargo->nome, 'Admin') === 0) {
                return true;
            }
            
            // Retorna null para deixar o Laravel continuar com as verificações normais.
            return null; 
        });

        /**
         * Define todos os "Gates" dinamicamente a partir do banco
         */
        try {
            // Usamos o cache para evitar consultar o banco em toda requisição.
            $telas = Cache::rememberForever('telas_permissoes', function () {
                // Pega todas as telas que têm um nome definido
                return Tela::whereNotNull('tela')->get();
            });

            foreach ($telas as $tela) {
                /*
                 * Para cada 'Tela' no banco (ex: "Editar Usuários"), 
                 * definimos um Gate (habilidade) com o mesmo nome.
                 */
                Gate::define($tela->tela, function (User $user) use ($tela) {

                    return $user->cargo->permissoes()
                        ->where('tela_id', $tela->id)
                        ->exists();
                });
            }
        } catch (Exception $e) {
            Log::error('Erro ao registrar Gates de permissão: ' . $e->getMessage());
        }
    }
}