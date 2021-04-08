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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function() {
    return 'Hola Mundo';
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Routas Configuracion
// Sedes
Route::get('/configuracion/sedes', [App\Http\Controllers\ConfiguracionController::class, 'index'])->name('sedes');
Route::post('/configuracion/sedes/create', [App\Http\Controllers\ConfiguracionController::class, 'create'])->name('sedes.create');
