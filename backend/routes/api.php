<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController; 

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/returnMessage', [ApiController::class, 'returnMessage']);
Route::post('/createStack', [ApiController::class, 'createStack']);
Route::get('/getStacks', [ApiController::class, 'getStacks']);
Route::delete('/deleteStack/{id}', [ApiController::class, 'deleteStack']);
Route::post('/editStack/{id}', [ApiController::class, 'editStack']);

Route::get('/getProjects', [ApiController::class, 'getProjects']);
Route::post('/createProject', [ApiController::class, 'createProject']);
Route::delete('/deleteProject/{id}', [ApiController::class, 'deleteProject']);
Route::post('/editProject/{id}', [ApiController::class, 'editProject']);

Route::post('/createMusicProject', [ApiController::class, 'createMusicProject']);
Route::get('/getMusicProjects', [ApiController::class, 'getMusicProjects']);
Route::delete('/deleteMusicProject/{id}', [ApiController::class, 'deleteMusicProject']);
Route::post('/editMusicProject/{id}', [ApiController::class, 'editMusicProject']);
