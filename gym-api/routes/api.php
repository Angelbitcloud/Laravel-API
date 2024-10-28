<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\user_gymController;

Route::get('/users', [user_gymController::class, 'listAll']);

Route::get('users/{id}', [user_gymController::class, 'listUserByID']);

Route::post('users', [user_gymController::class, 'createUser']);

Route::put('users/update/{id}', [user_gymController::class, 'updateUserByID']);

Route::put('users/{id}', [user_gymController::class, 'deletedByID']);
