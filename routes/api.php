<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehiculoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get-vehiculos', [VehiculoController::class, 'index']);
Route::post('/add-vehiculo', [VehiculoController::class, 'store']);
Route::put('/update-vehiculo/{id}', [VehiculoController::class, 'update']);
Route::put('/update-estado-vehiculo/{id}', [VehiculoController::class, 'updateEstadoVehiculo']);
Route::delete('/delete-vehiculo/{id}', [VehiculoController::class, 'destroy']);
Route::post('/download-registros-vehiculos', [VehiculoController::class, 'ExportRegister']);