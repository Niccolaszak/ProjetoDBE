<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use App\Interfaces\LivroRepositoryInterface;
use App\Repositories\EloquentLivroRepository;
use App\Interfaces\GeneroRepositoryInterface;
use App\Repositories\EloquentGeneroRepository;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\EloquentUserRepository;
use App\Interfaces\CargoRepositoryInterface;
use App\Repositories\EloquentCargoRepository;
use App\Interfaces\SetorRepositoryInterface;
use App\Repositories\EloquentSetorRepository;
use App\Interfaces\FornecedorRepositoryInterface;
use App\Repositories\EloquentFornecedorRepository;
use App\Interfaces\MovimentacaoRepositoryInterface;
use App\Repositories\EloquentMovimentacaoRepository;
use App\Interfaces\EstoqueRepositoryInterface;
use App\Repositories\EloquentEstoqueRepository;
use App\Interfaces\PermissaoRepositoryInterface;
use App\Repositories\EloquentPermissaoRepository;
use App\Interfaces\TelaRepositoryInterface;
use App\Repositories\EloquentTelaRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        /**
         * Liga a interface LivroRepositoryInterface à implementação Eloquent.
         */
        $this->app->bind(
            LivroRepositoryInterface::class,
            EloquentLivroRepository::class
        );

        /**
         * Liga a interface GeneroRepositoryInterface à implementação Eloquent.
         */
        $this->app->bind(
            GeneroRepositoryInterface::class,
            EloquentGeneroRepository::class
        );

        /**
         * Liga a interface UserRepositoryInterface à implementação Eloquent.
         */
        $this->app->bind(
            UserRepositoryInterface::class,
            EloquentUserRepository::class
        );

        /**
         * Liga a interface CargoRepositoryInterface à implementação Eloquent.
         */
        $this->app->bind(
            CargoRepositoryInterface::class,
            EloquentCargoRepository::class
        );

        /**
         * Liga a interface SetorRepositoryInterface à implementação Eloquent.
         */
        $this->app->bind(
            SetorRepositoryInterface::class,
            EloquentSetorRepository::class
        );

        /**
         * Liga a interface FornecedorRepositoryInterface à implementação Eloquent.
         */
        $this->app->bind(
            FornecedorRepositoryInterface::class,
            EloquentFornecedorRepository::class
        );

        /**
         * Liga a interface MovimentacaoRepositoryInterface à implementação Eloquent.
         */
        $this->app->bind(
            MovimentacaoRepositoryInterface::class,
            EloquentMovimentacaoRepository::class
        );

        /**
         * Liga a interface EstoqueRepositoryInterface à implementação Eloquent.
         */
        $this->app->bind(
            EstoqueRepositoryInterface::class,
            EloquentEstoqueRepository::class
        );

        /**
         * Liga a interface PermissaoRepositoryInterface à implementação Eloquent.
         */
        $this->app->bind(
            PermissaoRepositoryInterface::class,
            EloquentPermissaoRepository::class
        );

        /**
         * Liga a interface TelaRepositoryInterface à implementação Eloquent.
         */
        $this->app->bind(
            TelaRepositoryInterface::class,
            EloquentTelaRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
