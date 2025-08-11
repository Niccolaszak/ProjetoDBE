<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloWordController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/hello-word',[HelloWordController::class, 'exibirMensagem']);

