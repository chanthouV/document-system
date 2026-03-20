<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\FoldersController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\HealthController;

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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/test', [DocumentsController::class, 'test']); // Test route outside auth

// Health check endpoints (no authentication required)
Route::get('/health', [HealthController::class, 'index']);
Route::get('/ping', [HealthController::class, 'ping']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Folder CRUD routes
    Route::get('/folders', [FoldersController::class, 'index']);
    Route::post('/folders', [FoldersController::class, 'store']);
    Route::get('/folders/{folder}', [FoldersController::class, 'show']);
    Route::put('/folders/{folder}', [FoldersController::class, 'update']);
    Route::delete('/folders/{folder}', [FoldersController::class, 'destroy']);
    Route::get('/folder/tree', [FoldersController::class, 'tree']);
    
    // Document CRUD routes
    Route::get('/documents', [DocumentsController::class, 'index']);
    Route::post('/documents', [DocumentsController::class, 'store']);
    Route::get('/documents/{document}', [DocumentsController::class, 'show']);
    Route::put('/documents/{document}', [DocumentsController::class, 'update']);
    Route::delete('/documents/{document}', [DocumentsController::class, 'destroy']);
    Route::get('/documents/{document}/download', [DocumentsController::class, 'download']);
    Route::get('/folders/{folder}/documents', [DocumentsController::class, 'getByFolder']);
    
});

