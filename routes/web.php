<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloWorldController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/hello-world',[HelloWorldController::class, 'exibirMensagem']);

