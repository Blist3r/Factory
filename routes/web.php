<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/home', function() {
    return 'Hola Mundo';
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//Autenticación para que redireccione al LOGIN
Route::middleware(['auth'])->group(function () {
    //index
    Route::get('/', function () {
        return view('welcome');
    });
    // Routas Configuracion
    // Sedes
    Route::get('/configuracion/sedes', [App\Http\Controllers\ConfiguracionController::class, 'index'])->name('sedes');
    Route::post('/configuracion/sedes/create', [App\Http\Controllers\ConfiguracionController::class, 'create'])->name('sedes.create');
    Route::post('/configuracion/sedes/show', [App\Http\Controllers\ConfiguracionController::class, 'show'])->name('sedes.show');
    Route::get('/configuracion/sedes/delete/{id}', [App\Http\Controllers\ConfiguracionController::class, 'delete'])->name('sedes.delete');
    //Usuarios
    Route::get('/configuracion/users', [App\Http\Controllers\UsersController::class, 'index'])->name('users');
    Route::post('/configuracion/users/create', [App\Http\Controllers\UsersController::class, 'create'])->name('users.create');
    Route::post('/configuracion/users/show', [App\Http\Controllers\UsersController::class, 'show'])->name('users.show');
    Route::get('/configuracion/users/delete/{id}', [App\Http\Controllers\UsersController::class, 'delete'])->name('users.delete');
});