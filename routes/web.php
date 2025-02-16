<?php

use App\Http\Controllers\InscripcionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('inscripcion');
// });

// Route::get('/inscripcion', function () {
//     return view('inscripcion');
// })->name('inscripcion.index');

Route::get('/inscripcion', [InscripcionController::class, 'index'])->name('inscripcion.index');
Route::post('/inscripcion', [InscripcionController::class, 'store'])->name('inscripcion.store');
Route::post('/inscripcion/buscar', [InscripcionController::class, 'buscarDni'])->name('inscripcion.search');
