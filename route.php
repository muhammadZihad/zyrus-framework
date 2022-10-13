<?php

use App\Http\Controllers\HomeController;
use Zyrus\Route\Facade\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/home', 'App\Http\Controllers\HomeController@home');