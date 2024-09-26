<?php

use App\Http\Controllers\CarrierController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\RutaController;
use App\Http\Controllers\TruckController;
use App\Http\Controllers\EstatusController;
use App\Http\Controllers\RelacionesController;
use App\Http\Controllers\ContactoDirectoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IotController;
use App\Models\ContactoDirecto;
use App\Models\Relaciones;
use App\Models\Truck;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanPrensaController;
use App\Models\Carrier;
use Illuminate\Database\Eloquent\Relations\Relation;

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
    return redirect()->route('dashboard.index');
});



Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
     Route::resource('dashboard',DashboardController::class);
     Route::resource('trucks', truckController::class);

     Route::get('/chart-data', [IotController::class, 'getDataForChart']);
    // // Route::view('/cliente/cliente', 'cliente.cliente')->name('cliente.cliente');
    // Route::view('forms', 'forms')->name('forms');
    // Route::view('cards', 'cards')->name('cards');
    // Route::view('charts', 'charts')->name('charts');
    // Route::view('buttons', 'buttons')->name('buttons');
    // Route::view('modals', 'modals')->name('modals');
    // Route::view('tables', 'tables')->name('tables');
    // Route::view('calendar', 'calendar')->name('calendar');

    Route::resource('cliente', ClienteController::class);
    Route::resource('trucks', truckController::class);
    Route::resource('Estatus',EstatusController::class);
    Route::resource('Carrier', CarrierController::class);
    Route::resource('Ruta', RutaController::class);
    Route::resource('Contactodirecto', ContactoDirectoController::class);
    Route::resource('Relaciones', RelacionesController::class);

    // Route::post('IOT.excel', [plancpController::class, 'index'])->name('IOT.index');
    Route::post('cliente.nuevo', [ClienteController::class, 'store'])->name('cliente.nuevo');
    Route::delete('cliente/{id}', [ClienteController::class, 'destroy'])->name('cliente.destroy');
    Route::delete('Contacto_directo/{id}', [ContactoDirectoController::class, 'destroy'])->name('contactodirecto.destroy');
    Route::delete('ruta/{id}', [RutaController::class, 'destroy'])->name('ruta.destroy');
    Route::delete('carrier/{id}', [CarrierController::class, 'destroy'])->name('carrier.destroy');
    Route::post('carrier.nuevo', [CarrierController::class, 'store'])->name('carrier.nuevo');
    Route::get('carrier.destroy', [CarrierController::class, 'destroy'])->name('carrier.destroy');
    Route::post('ruta.ruta', [RutaController::class, 'store'])->name('ruta.nuevo');
    Route::post('Contacto_directo.ruta', [ContactoDirectoController::class, 'store'])->name('contactodirecto.nuevo');
    Route::post('relaciones.create', [RelacionesController::class, 'store'])->name('Relaciones.create');
    Route::get('Relaciones.destroy', [RelacionesController::class, 'destroy'])->name('relaciones.destroy');
    Route::post('truck.create', [TruckController::class, 'store'])->name('truck.create');
    Route::post('truck.update', [TruckController::class, 'update'])->name('truck.update');
    Route::post('truck.status', [TruckController::class, 'status'])->name('truck.status');
    Route::get('truck-test/{id}/{status}', [TruckController::class, 'test'])->name('truck.test');
});
