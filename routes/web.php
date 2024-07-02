<?php

use App\Http\Controllers\CarrierController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\RutaController;
use App\Http\Controllers\TruckController;
use App\Http\Controllers\EstatusController;
use App\Http\Controllers\RelacionesController;
use App\Http\Controllers\ContactoDirectoController;


use App\Models\ContactoDirecto;
use App\Models\Relaciones;
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

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');


Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
     Route::resource('dashboard', truckController::class);
    // // Route::view('/cliente/cliente', 'cliente.cliente')->name('cliente.cliente');
    Route::view('forms', 'forms')->name('forms');
    Route::view('cards', 'cards')->name('cards');
    Route::view('charts', 'charts')->name('charts');
    Route::view('buttons', 'buttons')->name('buttons');
    Route::view('modals', 'modals')->name('modals');
    Route::view('tables', 'tables')->name('tables');
    Route::view('calendar', 'calendar')->name('calendar');

    Route::resource('cliente', ClienteController::class);
    Route::resource('trucks', truckController::class);
    Route::resource('Estatus',EstatusController::class);
    Route::resource('Carrier', CarrierController::class);
    Route::resource('Ruta', RutaController::class);
    Route::resource('Contactodirecto', ContactoDirectoController::class);
    Route::resource('Relaciones', RelacionesController::class);


    Route::post('cliente.nuevo', [ClienteController::class, 'store'])->name('cliente.nuevo');
    Route::post('cliente.destroy', [ClienteController::class, 'destroyer'])->name('cliente.destroy');
    Route::post('carrier.nuevo', [CarrierController::class, 'store'])->name('carrier.nuevo');
    Route::post('carrier.destroy', [CarrierController::class, 'destroy'])->name('carrier.destroy');
    Route::post('ruta.ruta', [RutaController::class, 'store'])->name('ruta.nuevo');
    Route::post('Contacto_directo.ruta', [ContactoDirectoController::class, 'store'])->name('contactodirecto.nuevo');
    Route::post('relaciones.create', [RelacionesController::class, 'store'])->name('Relaciones.create');
    Route::post('truck.create', [TruckController::class, 'store'])->name('truck.create');
});
