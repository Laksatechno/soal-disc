<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\AuthController;

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
Route::get('/test/selesai/{user}', [TestController::class, 'selesai'])->name('test.selesai');

// Route untuk login admin
Route::prefix('admin')->group(function () {
    // Route untuk menampilkan form login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('admin.login');

    // Route untuk memproses login (AJAX/JSON)
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');

    // Route untuk logout admin
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
});

// Route untuk admin yang sudah login (dilindungi oleh middleware 'admin')
Route::prefix('admin')->middleware('admin')->group(function () {
    // Route untuk menampilkan halaman index admin
    Route::get('index', [AdminController::class, 'indexadmin'])->name('admin.index');

    // Route untuk menampilkan form create admin
    Route::get('create', [AdminController::class, 'create'])->name('admin.create');

    // Route untuk menyimpan data admin
    Route::post('store', [AdminController::class, 'simpansoaladmin'])->name('admin.store');

    // Route untuk menampilkan form edit admin
    Route::get('{question}/edit', [AdminController::class, 'edit'])->name('admin.edit');

    // Route untuk mengupdate data admin
    Route::put('{question}', [AdminController::class, 'update'])->name('admin.update');

    // Route untuk menghapus data admin
    Route::delete('{question}', [AdminController::class, 'destroy'])->name('admin.destroy');

    // Route untuk menampilkan riwayat jawaban
    Route::get('riwayatjawaban', [AdminController::class, 'riwayatjawaban'])->name('admin.riwayatjawaban');

    // Route untuk menampilkan detail jawaban
    Route::get('detail/{id}', [AdminController::class, 'detailjawaban'])->name('admin.detailjawaban');
});