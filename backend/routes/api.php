<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColaboradorController;
use App\Http\Controllers\AtivoController;
use App\Http\Controllers\MovimentacaoAtivoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// 1. ROTA PÚBLICA: Login
Route::post('/login', [AuthController::class, 'login']);

// 2. ROTAS PROTEGIDAS (Apenas usuários logados com Token Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    
    // Retorna os dados do usuário logado
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // CRUDs Completos (Index, Store, Show, Update, Delete)
    Route::apiResource('colaboradores', ColaboradorController::class);
    Route::apiResource('produtos', ProdutoController::class);
    Route::apiResource('ativos', AtivoController::class);

    // Movimentações (Entrega/Devolução)
    // Adicionamos o GET para que o Vue consiga listar o histórico
    Route::get('movimentacoes', [MovimentacaoAtivoController::class, 'index']); 
    Route::post('movimentacoes', [MovimentacaoAtivoController::class, 'store']);
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});