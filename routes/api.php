<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatentController;
use App\Http\Controllers\ResearchAreaController;
use App\Http\Controllers\ResearchPublicationController;

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



Route::get('/patents', [PatentController::class, 'index']);
Route::post('/patents/create', [PatentController::class, 'store']);
Route::post('/patents/{id}', [PatentController::class, 'edit']);
Route::delete('/patents/delete/{id}', [PatentController::class, 'delete']);
Route::get('/research-area', [ResearchAreaController::class, 'index']);

Route::post('/research-area/create', [ResearchAreaController::class, 'create']);
Route::post('/research-area/edit/{id}', [ResearchAreaController::class, 'edit']);

Route::delete('/research-area/delete/{id}', [ResearchAreaController::class, 'delete']);

Route::get('/research-publication', [ResearchPublicationController::class, 'index']);
Route::get('/research-publication/detail/{id}', [ResearchPublicationController::class, 'index']);

Route::post('/research-publication/create', [ResearchPublicationController::class, 'create']);
Route::post('/research-publication/edit/{id}', [ResearchPublicationController::class, 'edit']);

Route::delete('/research-publication/delete/{id}', [ResearchPublicationController::class, 'delete']);
