<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenjokiController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ProjectController;
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

    Route::get('admin/pelanggan', [PelangganController::class, 'index'])->name('admin.pelanggan');
    Route::get('admin/pelanggan/getListData', [PelangganController::class, 'listData'])->name('admin.pelanggan.list');
    Route::get('admin/pelanggan/add', [PelangganController::class, 'create'])->name('admin.pelanggan.add');
    Route::post('admin/pelanggan/store', [PelangganController::class, 'store'])->name('admin.pelanggan.store');
    Route::get('admin/pelanggan/{id}', [PelangganController::class, 'edit'])->name('admin.pelanggan.edit');
    Route::put('admin/pelanggan/update/{id}', [PelangganController::class, 'update'])->name('admin.pelanggan.update');
    Route::get('admin/pelanggan/delete/{id}', [PelangganController::class, 'destroy'])->name('admin.pelanggan.delete');

    Route::get('admin/penjoki', [PenjokiController::class, 'index'])->name('admin.penjoki');
    Route::get('admin/penjoki/getListData', [PenjokiController::class, 'listData'])->name('admin.penjoki.list');
    Route::get('admin/penjoki/add', [PenjokiController::class, 'create'])->name('admin.penjoki.add');
    Route::post('admin/penjoki/store', [PenjokiController::class, 'store'])->name('admin.penjoki.store');
    Route::get('admin/penjoki/{id}', [PenjokiController::class, 'edit'])->name('admin.penjoki.edit');
    Route::put('admin/penjoki/update/{id}', [PenjokiController::class, 'update'])->name('admin.penjoki.update');
    Route::get('admin/penjoki/delete/{id}', [PenjokiController::class, 'destroy'])->name('admin.penjoki.delete');

    Route::get('admin/project', [ProjectController::class, 'index'])->name('admin.project');
    Route::get('admin/project/getListData', [ProjectController::class, 'listData'])->name('admin.project.list');
    Route::get('admin/project/add', [ProjectController::class, 'create'])->name('admin.project.add');
    Route::post('admin/project/store', [ProjectController::class, 'store'])->name('admin.project.store');
    Route::get('admin/project/{id}', [ProjectController::class, 'edit'])->name('admin.project.edit');
    Route::put('admin/project/update/{id}', [ProjectController::class, 'update'])->name('admin.project.update');
    Route::get('admin/project/delete/{id}', [ProjectController::class, 'destroy'])->name('admin.project.delete');


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
