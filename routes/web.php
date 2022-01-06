<?php

use App\Http\Controllers\JabatanController;
use App\Http\Controllers\KaryawanController;
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

Route::get('/', [KaryawanController::class, 'index']);
Route::get('data_jabatan', [KaryawanController::class, 'data_jabatan']);
Route::post('karyawan', [KaryawanController::class, 'store']);
Route::get('karyawan/{id}', [KaryawanController::class, 'show']);
Route::post('karyawan/{id}', [KaryawanController::class, 'update']);
Route::delete('karyawan/{id}', [KaryawanController::class, 'delete']);

Route::get('jabatan', [JabatanController::class, 'index']);
Route::get('jabatan/{id}', [JabatanController::class, 'show']);
Route::post('jabatan', [JabatanController::class, 'store']);
Route::patch('jabatan/{id}', [JabatanController::class, 'update']);
Route::delete('jabatan/{id}', [JabatanController::class, 'delete']);