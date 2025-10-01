<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rotas que exigem autenticação via API token
Route::middleware('auth:api')->group(function() {
    
    // Rota para criar cliente via API (para n8n)
    Route::post('/clients', [ClientController::class, 'store']);
});
