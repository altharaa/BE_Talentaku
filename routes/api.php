<?php

use App\Http\Controllers\API\AlbumController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\GradeController;
use App\Http\Controllers\API\InformationController;
use App\Http\Controllers\API\ProgramController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'destroy'])->middleware('auth:sanctum');
});

Route::prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'show'])->middleware('auth:sanctum');
    Route::post('/update-photo', [UserController::class, 'updatePhoto'])->middleware('auth:sanctum');
    Route::post('/update-password', [UserController::class, 'updatePassword'])->middleware('auth:sanctum');
});

Route::prefix('programs')->group(function () {
    Route::get('/', [ProgramController::class, 'show']);
    Route::post('/add', [ProgramController::class, 'store'])->middleware('auth:sanctum');
    Route::post('/{id}', [ProgramController::class, 'update'])->middleware('auth:sanctum');
    Route::delete('/{id}', [ProgramController::class, 'destroy'])->middleware('auth:sanctum');
});

Route::prefix('information')->group(function () {
    Route::get('/', [InformationController::class, 'show']);
    Route::post('/add', [InformationController::class, 'store'])->middleware('auth:sanctum');
    Route::put('/{id}', [InformationController::class, 'update'])->middleware('auth:sanctum');
    Route::delete('/{id}', [InformationController::class, 'destroy'])->middleware('auth:sanctum');
    Route::get('/list', [InformationController::class, 'get']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('grades')->group(function () {
        Route::get('/', [GradeController::class, 'show']);
        Route::get('/{id}', [GradeController::class, 'detail']);
        Route::post('/add', [GradeController::class, 'store']);
        Route::put('/{id}', [GradeController::class, 'update']);
        Route::patch('/{id}/toggle-active', [GradeController::class, 'toggleActive']);
        Route::post('/join', [GradeController::class, 'join']);
        Route::delete('/{gradeId}/members/{memberId}', [GradeController::class, 'deleteMember'])->middleware('auth:api');
    });

    Route::prefix('albums')->group(function () {
        Route::get('/{id}', [AlbumController::class, 'show']);
        Route::post('/add', [AlbumController::class, 'store']);
        Route::delete('/{id}', [AlbumController::class, 'destroy']);
    });
});

 