<?php

use App\Http\Controllers\Api\CatController;
use Illuminate\Support\Facades\Route;

Route::apiResource('cats', CatController::class);
