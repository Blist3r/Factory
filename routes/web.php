<?php

use Illuminate\Support\Facades\Route;

Route::get('/home', function() {
    return 'Hola Mundo';
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//Autenticación para que redireccione al LOGIN
Route::middleware(['auth'])->group(function () {
    //index
    Route::get('/', [App\Http\Controllers\VentaController::class, 'index'])->name('venta');

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
        // Roles
        Route::get('/configuracion/roles', [App\Http\Controllers\ConfiguracionController::class, 'roles'])->name('roles');
        Route::post('/configuracion/roles/create', [App\Http\Controllers\ConfiguracionController::class, 'roles_create'])->name('roles.create');
        Route::post('/configuracion/roles/show', [App\Http\Controllers\ConfiguracionController::class, 'roles_show'])->name('roles.show');
        Route::get('/configuracion/roles/delete/{id}', [App\Http\Controllers\ConfiguracionController::class, 'roles_delete'])->name('roles.delete');
        // Permisos
        Route::get('/configuracion/permisos', [App\Http\Controllers\ConfiguracionController::class, 'permisos'])->name('permisos');
        Route::post('/configuracion/permisos/create', [App\Http\Controllers\ConfiguracionController::class, 'permisos_create'])->name('permisos.create');
        Route::post('/configuracion/permisos/show', [App\Http\Controllers\ConfiguracionController::class, 'permisos_show'])->name('permisos.show');
        Route::get('/configuracion/permisos/delete/{id}', [App\Http\Controllers\ConfiguracionController::class, 'permisos_delete'])->name('permisos.delete');
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

        // Rutas de Reportes
        // Ventas
        Route::prefix('reportes')->group(function () {
            Route::get('ventas', [App\Http\Controllers\ReportesController::class, 'ventas'])->name('ventas');
            Route::get('ventas/filtro', [App\Http\Controllers\ReportesController::class, 'ventas'])->name('ventas.filtro');
            Route::post('buscar_ventas', [App\Http\Controllers\ReportesController::class, 'buscar_ventas'])->name('buscar_ventas');
            Route::post('exportar_ventas', [App\Http\Controllers\VentaController::class, 'exportar_ventas'])->name('exportar_ventas');
            Route::post('imprimir_ventas', [App\Http\Controllers\VentaController::class, 'imprimir_ventas'])->name('imprimir_ventas');
            Route::post('print_cierre', [App\Http\Controllers\VentaController::class, 'print_cierre'])->name('print_cierre');
        });

    });

    //Clientes
    Route::get('/configuracion/clientes', [App\Http\Controllers\ClientesController::class, 'index'])->name('clientes');
    Route::post('/configuracion/clientes/create', [App\Http\Controllers\ClientesController::class, 'create'])->name('clientes.create');
    Route::post('/configuracion/clientes/show', [App\Http\Controllers\ClientesController::class, 'show'])->name('clientes.show');
    Route::get('/configuracion/clientes/delete/{id}', [App\Http\Controllers\ClientesController::class, 'delete'])->name('clientes.delete');

    // Ventas
    Route::post('/ventas/show', [App\Http\Controllers\VentaController::class, 'show'])->name('ventas.show');
    Route::post('/ventas/searchCliente', [App\Http\Controllers\VentaController::class, 'searchCliente'])->name('ventas.searchCliente');
    Route::post('/ventas/validarVendedor', [App\Http\Controllers\VentaController::class, 'validarVendedor'])->name('ventas.validarVendedor');
    Route::post('/ventas/realizarVenta', [App\Http\Controllers\VentaController::class, 'realizarVenta'])->name('ventas.realizarVenta');
});
