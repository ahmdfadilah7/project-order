<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenjokiController;
use App\Http\Controllers\SettingController;
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

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::get('logout/{slug}', [AuthController::class, 'logout'])->name('logout');

Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('prosesLogin', [AuthController::class, 'proses_login'])->name('prosesLogin');
Route::post('prosesRegister', [AuthController::class, 'proses_register'])->name('prosesRegister');

Route::group(['middleware' => ['auth:admin', 'role:admin']], function () {

    Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('admin/penjoki', [PenjokiController::class, 'index'])->name('admin.penjoki');
    Route::get('admin/penjoki/getListData', [PenjokiController::class, 'listData'])->name('admin.penjoki.list');
    Route::get('admin/penjoki/add', [PenjokiController::class, 'create'])->name('admin.penjoki.add');
    Route::post('admin/penjoki/store', [PenjokiController::class, 'store'])->name('admin.penjoki.store');
    Route::get('admin/penjoki/{id}', [PenjokiController::class, 'edit'])->name('admin.penjoki.edit');
    Route::put('admin/penjoki/update/{id}', [PenjokiController::class, 'update'])->name('admin.penjoki.update');
    Route::get('admin/penjoki/delete/{id}', [PenjokiController::class, 'destroy'])->name('admin.penjoki.delete');

    Route::get('admin/setting', [SettingController::class, 'index'])->name('admin.setting');
    Route::get('admin/setting/getListData', [SettingController::class, 'listData'])->name('admin.setting.list');
    Route::get('admin/setting/{id}', [SettingController::class, 'edit'])->name('admin.setting.edit');
    Route::put('admin/setting/update/{id}', [SettingController::class, 'update'])->name('admin.setting.update');

});

Route::group(['middleware' => ['auth:penjoki', 'role:penjoki']], function() {

    Route::get('penjoki/dashboard', [DashboardController::class, 'index'])->name('penjoki.dashboard');

});

Route::group(['middleware' => ['auth:pelanggan', 'role:pelanggan']], function() {

    Route::get('pelanggan/dashboard', [DashboardController::class, 'index'])->name('pelanggan.dashboard');

});
