<?php

use App\Http\Controllers\Api\CatController;
use Illuminate\Support\Facades\Route;

Route::delete('cats/{id}', [CatController::class, 'destroy']);
Route::apiResource('cats', CatController::class)->except(['destroy']);
