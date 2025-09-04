<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloWorldController;
use App\Http\Middleware\ForcarRedefinirSenha;
use App\Http\Controllers\SenhaController;
use App\Http\Controllers\PermissaoController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello-world', [HelloWorldController::class, 'exibirMensagem']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', ForcarRedefinirSenha::class])
  ->name('dashboard');

Route::middleware(['auth', 'check.permission'])->group(function () {
    Route::resource('permissoes', PermissaoController::class)->except(['edit', 'update', 'show']);
});

Route::middleware(['auth', ForcarRedefinirSenha::class])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/senha/redefinir', [SenhaController::class, 'show'])->name('senha.redefinir');
Route::post('/senha/redefinir', [SenhaController::class, 'update']);

require __DIR__.'/auth.php';
