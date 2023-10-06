<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductosController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/productos/get', [ProductosController::class, 'index']);
Route::post('/productos/post', [ProductosController::class, 'store']);
Route::put('/productos/put/{id}', [ProductosController::class, 'update'])->where('id', '[0-9]+');
Route::delete('/productos/delete/{id}', [ProductosController::class, 'destroy'])->where('id', '[0-9]+');



