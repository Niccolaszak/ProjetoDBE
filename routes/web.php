<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloWorldController;
use App\Http\Middleware\ForcarRedefinirSenha;
use App\Http\Controllers\SenhaController;
use App\Http\Controllers\PermissaoController;
use App\Http\Controllers\CargosController;
use App\Http\Controllers\SetoresController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\GeneroController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\MovimentacaoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Models\Fornecedor;

Route::middleware('guest')->group(function () {
    // Login será a página inicial
    Route::get('/', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::get('/senha/redefinir', [SenhaController::class, 'show'])->name('senha.redefinir');
Route::post('/senha/redefinir', [SenhaController::class, 'update']);

Route::middleware(['auth', ForcarRedefinirSenha::class])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/painel', fn() => view('painelControle'))
         ->middleware('can:Consultar Painel')
         ->name('painel');

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/destroy', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::resource('permissoes', PermissaoController::class)
        ->except(['edit', 'update', 'show'])
        ->parameters(['permissoes' => 'permissao']);

    Route::resource('estoques', EstoqueController::class)
        ->except(['create','store','edit','update','destroy']);

    Route::resource('movimentacoes', MovimentacaoController::class)
        ->except(['show','edit','update']);

    Route::resource('users', UserController::class)
        ->except(['edit','show']);

    Route::resource('setores', SetoresController::class)
        ->except(['edit', 'update', 'show']);
            
    Route::resource('cargos', CargosController::class)
        ->except(['edit', 'update', 'show']);

    Route::resource('fornecedores', FornecedorController::class)
        ->except(['show','edit', 'create']);

    Route::resource('generos', GeneroController::class)
        ->except(['show','edit','update']);
        
    Route::resource('livros', LivroController::class);

});

require __DIR__.'/auth.php';
