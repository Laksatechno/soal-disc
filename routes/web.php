<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AdminController;

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

Route::get('/', [TestController::class, 'index']);
Route::post('/test', [TestController::class, 'store'])->name('test.store');
Route::get('/test/result/{user}', [TestController::class, 'result'])->name('test.result');

Route::get('admin', [AdminController::class, 'indexadmin'])->name('admin.index');
Route::get('admin/create', [AdminController::class, 'create'])->name('admin.create');
Route::post('admin', [AdminController::class, 'simpansoaladmin'])->name('admin.store');
Route::get('admin/{question}/edit', [AdminController::class, 'edit'])->name('admin.edit');
Route::put('admin/{question}', [AdminController::class, 'update'])->name('admin.update');
Route::delete('admin/{question}', [AdminController::class, 'destroy'])->name('admin.destroy');
Route::get('admin/riwayatjawaban' , [AdminController::class, 'riwayatjawaban'])->name('admin.riwayatjawaban');
Route::get('admin/detail/{id}', [AdminController::class, 'detailjawaban'])->name('admin.detailjawaban');