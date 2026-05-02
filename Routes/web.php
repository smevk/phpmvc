<?php

use Php\Mvc\App\Http\Controllers\UserController;
use Php\Mvc\App\Http\Services\Route;



Route::post('users/{user_id}',[UserController::class,'store']);
Route::get('users/{user_id}',[UserController::class,'show']);

