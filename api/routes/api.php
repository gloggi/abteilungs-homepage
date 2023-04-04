<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\AuthController;



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

Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);


Route::get('/groups', [GroupController::class, 'index']);
Route::get('/groups/{id}', [GroupController::class, 'show']);
Route::post('/groups', [GroupController::class, 'store']);
Route::put('/groups/{id}', [GroupController::class, 'update']);
Route::delete('/groups/{id}', [GroupController::class, 'destroy']);

Route::get('/pages', [PageController::class, 'index']);
Route::get('/pages/{id}', [PageController::class, 'show']);
Route::post('/pages', [PageController::class, 'store']);
Route::put('/pages/{id}', [PageController::class, 'update']);
Route::delete('/pages/{id}', [PageController::class, 'destroy']);

Route::get('/files', [FileController::class, 'index']);
Route::post('/files', [FileController::class, 'store']);
Route::get('/files/{id}', [FileController::class, 'show']);
Route::put('/files/{id}', [FileController::class, 'update']);
Route::delete('/files/{id}', [FileController::class, 'destroy']);
