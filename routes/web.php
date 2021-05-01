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
    //Valida que el usuario tenga el rol en este caso "admin"
    Route::group(['middleware' => ['role:admin']], function () {
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
        //Categorias
        Route::get('/configuracion/categorias', [App\Http\Controllers\ConfiguracionController::class, 'index_categorias'])->name('categorias');
        Route::post('/configuracion/categorias/create', [App\Http\Controllers\ConfiguracionController::class, 'create_categorias'])->name('categorias.create');
        Route::post('/configuracion/categorias/show', [App\Http\Controllers\ConfiguracionController::class, 'show_categorias'])->name('categorias.show');
        Route::get('/configuracion/categorias/delete/{id}', [App\Http\Controllers\ConfiguracionController::class, 'delete_categorias'])->name('categorias.delete');
        //Productos
        Route::get('/configuracion/productos', [App\Http\Controllers\ProductosController::class, 'index'])->name('productos');
        Route::post('/configuracion/productos/create', [App\Http\Controllers\ProductosController::class, 'create'])->name('productos.create');
        Route::post('/configuracion/productos/show', [App\Http\Controllers\ProductosController::class, 'show'])->name('productos.show');
        Route::get('/configuracion/productos/delete/{id}', [App\Http\Controllers\ProductosController::class, 'delete'])->name('productos.delete');
    });
     //Clientes
     Route::get('/configuracion/clientes', [App\Http\Controllers\ClientesController::class, 'index'])->name('clientes');
     Route::post('/configuracion/clientes/create', [App\Http\Controllers\ClientesController::class, 'create'])->name('clientes.create');
     Route::post('/configuracion/clientes/show', [App\Http\Controllers\ClientesController::class, 'show'])->name('clientes.show');
     Route::get('/configuracion/clientes/delete/{id}', [App\Http\Controllers\ClientesController::class, 'delete'])->name('clientes.delete');
});
