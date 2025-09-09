<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloWorldController;
use App\Http\Middleware\ForcarRedefinirSenha;
use App\Http\Controllers\SenhaController;
use App\Http\Controllers\PermissaoController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;


Route::middleware('guest')->group(function () {
    // Login será a página inicial
    Route::get('/', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::get('/senha/redefinir', [SenhaController::class, 'show'])->name('senha.redefinir');
Route::post('/senha/redefinir', [SenhaController::class, 'update']);

Route::get('/hello-world', [HelloWorldController::class, 'exibirMensagem']);
Route::middleware(['auth', ForcarRedefinirSenha::class])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('/painel', fn() => view('painelControle'))->name('painel');

    Route::prefix('profile')->group(function () {
            Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
        });
        
    Route::middleware(['check.permission'])->group(function () {

        Route::resource('permissoes', PermissaoController::class)
            ->except(['edit', 'update', 'show']);

        Route::prefix('profile')->group(function () {
            Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });
        Route::get('/usuarios', [App\Http\Controllers\Auth\RegisteredUserController::class, 'index'])->name('usuarios.index');
        Route::get('/register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'create'])->name('register.create');
        Route::post('/register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'store'])->name('register.store');
    });
});

require __DIR__.'/auth.php';
