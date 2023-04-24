<?php

use Php\Mvc\App\Http\Controllers\UserController;
use Php\Mvc\App\Http\Services\Route;



Route::get('users/{user_id}/show/{test}/hello',[UserController::class,'show']);
Route::post('users/{user_id}/show/{test}/hello',[UserController::class,'show']);
Route::delete('users/{user_id}/show/{test}/hello',[UserController::class,'show']);

