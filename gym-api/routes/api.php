<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/users', function() {
    return 'Conseguir todos los usuarios';
});

Route::get('users/{id}', function ($id) {
    return 'conseguir un usuario por id';    
});

Route::post('users/{id}', function ($id) {
    return 'crear un usuario';    
});

Route::delete('users/{id}', function ($id) {
    return 'eliminar un usuario';
});

Route::put('users/{id}', function ($id) {
    return 'actualizar un usuario';
});
