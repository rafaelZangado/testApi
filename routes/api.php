<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->post('/logout', [UserController::class, 'userLogout']);

Route::controller(UserController::class)->group(function(){
    Route::post('login','loginUser');
});

Route::controller(UserController::class)->group(function(){
    Route::get('user','getUserDetail');
    Route::get('logout','userLogout');
})->middleware('auth:api');

Route::middleware(['auth:api', 'verificarLevel:visualizar'])->group(function () {
    Route::post('add', [UserController::class, 'addItem']);
    Route::get('listar', [UserController::class, 'listarItens']);
});

Route::middleware(['auth:api', 'verificarLevel:editar'])->group(function () {
    Route::put('editar/{id}', [UserController::class, 'editarItem']);
});

Route::middleware(['auth:api', 'verificarLevel:deletar'])->group(function () {
    Route::delete('deletar/{id}', [UserController::class, 'deletarItem']);
});
