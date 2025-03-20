<?php

use App\Http\Controllers\Api\CreatePermissionRolController;
use App\Http\Controllers\Api\MntPedidosController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\CtlCategoriaController;
use App\Http\Controllers\Api\CtlProductosController;
use App\Http\Controllers\Api\MntClientesController;
use Illuminate\Support\Facades\Route;

// Rutas de Autenticación
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/refresh-token', [AuthController::class, 'refresh']);

    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
    });
});

// Rutas de Usuarios y Permisos (Protegidas con auth:api)
Route::middleware('auth:api')->prefix('users')->group(function () {
    Route::get('/role', [CreatePermissionRolController::class, 'getRole'])->middleware('rol:Super Admin');
    Route::post('/permissions', [CreatePermissionRolController::class, 'createPermissionsAction'])->middleware('rol:Super Admin,Admin');
    Route::post('/role', [CreatePermissionRolController::class, 'store'])->middleware('rol:Super Admin');
});

// Dashboard de Administración (Protegido con roles)
Route::middleware(['auth:api', 'rol:Admin,Super Admin'])->get('/admin-dashboard', function () {
    return response()->json(['message' => 'Welcome to the admin dashboard']);
});

// Rutas de Administración (Protegidas con auth:api)
Route::middleware('auth:api')->prefix('administracion')->group(function () {
    Route::prefix('categoria')->middleware('rol:Admin')->group(function () {
        Route::post('/', [CtlCategoriaController::class, 'store']);
        Route::put('/{id}', [CtlCategoriaController::class, 'update']);
        Route::patch('/{id}', [CtlCategoriaController::class, 'deleteCategoria']);
    });

    Route::prefix('productos')->middleware('rol:Admin')->group(function () {
        Route::post('/', [CtlProductosController::class, 'store']);
        Route::put('/inventario/{id}', [CtlProductosController::class, 'updateInventario']);
        Route::patch('/{id}', [CtlProductosController::class, 'deleteProducto']);
    });
});

// Catálogo Público (Accesible sin autenticación)
Route::prefix('catalogo')->group(function () {
    Route::get('/categoria', [CtlCategoriaController::class, 'index']);
    Route::get('/productos', [CtlProductosController::class, 'index']);
});

// Rutas de Pedidos (Protegidas con auth:api)
Route::middleware('auth:api')->prefix('pedidos')->group(function () {
    Route::get('/', [MntPedidosController::class, 'index']);
    Route::post('/', [MntPedidosController::class, 'store']);
});

// Rutas de Clientes (Accesible sin autenticación)
Route::prefix('clientes')->group(function () {
    Route::post('/', [MntClientesController::class, 'store']);
});

// Ruta de Prueba
Route::get('/test', function () {
    return response()->json(['message' => 'Ruta de prueba funcionando']);
});
