<?php

use App\Http\Controllers\EventCategoryController;
use App\Http\Controllers\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatentController;
use App\Http\Controllers\ResearchAreaController;
use App\Http\Controllers\ResearchPublicationController;
use App\Http\Controllers\UserController;

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


Route::get('/event-category/detail/{id}', [EventCategoryController::class, 'index']);

Route::post('/event-category/create', [EventCategoryController::class, 'create']);
Route::post('/event-category/edit/{id}', [EventCategoryController::class, 'edit']);

Route::delete('/event-category/delete/{id}', [EventCategoryController::class, 'delete']);
Route::get('/event', [EventCategoryController::class, 'index']);


Route::post('/event/create', [EventController::class, 'create']);
Route::post('/event/edit/{id}', [EventController::class, 'edit']);

Route::delete('/event/delete/{id}', [EventController::class, 'delete']);


Route::get('/user', [UserController::class,'index']);
