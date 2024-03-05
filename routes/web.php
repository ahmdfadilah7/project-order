<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileProjectController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Pelanggan\DashboardController as PelangganDashboardController;
use App\Http\Controllers\Pelanggan\FileProjectController as PelangganFileProjectController;
use App\Http\Controllers\Pelanggan\GroupController as PelangganGroupController;
use App\Http\Controllers\Pelanggan\OrderController as PelangganOrderController;
use App\Http\Controllers\PenjokiController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\Penjoki\ActivitiesController;
use App\Http\Controllers\Penjoki\DashboardController as PenjokiDashboardController;
use App\Http\Controllers\Penjoki\FileProjectController as PenjokiFileProjectController;
use App\Http\Controllers\Penjoki\GroupController as PenjokiGroupController;
use App\Http\Controllers\Penjoki\OrderController as PenjokiOrderController;
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

Route::group(['middleware' => 'auth'], function () {
    Route::get('notif/group/chat/{id}', [NotificationController::class, 'group'])->name('notif.group');
});

Route::group(['middleware' => ['auth:admin', 'role:admin']], function () {

    Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('admin/group', [GroupController::class, 'index'])->name('admin.group');
    Route::get('admin/group/chat/{id}', [GroupController::class, 'chat'])->name('admin.group.chat');
    Route::get('admin/group/receive/{id}', [GroupController::class, 'receive'])->name('admin.group.receive');
    Route::post('admin/group/chatadd', [GroupController::class, 'store'])->name('admin.group.chatadd');

    Route::get('admin/order', [OrderController::class, 'index'])->name('admin.order');
    Route::get('admin/order/getListData', [OrderController::class, 'listData'])->name('admin.order.list');
    Route::get('admin/order/add', [OrderController::class, 'create'])->name('admin.order.add');
    Route::get('admin/order/detail/{id}', [OrderController::class, 'show'])->name('admin.order.detail');
    Route::get('admin/order/activities/{id}', [OrderController::class, 'activity'])->name('admin.order.activities');
    Route::post('admin/order/store', [OrderController::class, 'store'])->name('admin.order.store');
    Route::get('admin/order/{id}', [OrderController::class, 'edit'])->name('admin.order.edit');
    Route::put('admin/order/update/{id}', [OrderController::class, 'update'])->name('admin.order.update');
    Route::get('admin/order/delete/{id}', [OrderController::class, 'destroy'])->name('admin.order.delete');

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

    Route::get('admin/fileproject/getListData/{id}', [FileProjectController::class, 'listData'])->name('admin.fileproject.list');
    Route::post('admin/fileproject/store', [FileProjectController::class, 'store'])->name('admin.fileproject.store');
    Route::get('admin/fileproject/delete/{id}', [FileProjectController::class, 'destroy'])->name('admin.fileproject.delete');

    Route::get('admin/jenis', [JenisController::class, 'index'])->name('admin.jenis');
    Route::get('admin/jenis/getListData', [JenisController::class, 'listData'])->name('admin.jenis.list');
    Route::get('admin/jenis/add', [JenisController::class, 'create'])->name('admin.jenis.add');
    Route::post('admin/jenis/store', [JenisController::class, 'store'])->name('admin.jenis.store');
    Route::get('admin/jenis/{id}', [JenisController::class, 'edit'])->name('admin.jenis.edit');
    Route::put('admin/jenis/update/{id}', [JenisController::class, 'update'])->name('admin.jenis.update');
    Route::get('admin/jenis/delete/{id}', [JenisController::class, 'destroy'])->name('admin.jenis.delete');

    Route::get('admin/setting', [SettingController::class, 'index'])->name('admin.setting');
    Route::get('admin/setting/getListData', [SettingController::class, 'listData'])->name('admin.setting.list');
    Route::get('admin/setting/{id}', [SettingController::class, 'edit'])->name('admin.setting.edit');
    Route::put('admin/setting/update/{id}', [SettingController::class, 'update'])->name('admin.setting.update');
});

Route::group(['middleware' => ['xss', 'auth:penjoki', 'role:penjoki']], function () {

    Route::get('penjoki/dashboard', [PenjokiDashboardController::class, 'index'])->name('penjoki.dashboard');

    Route::get('penjoki/group', [PenjokiGroupController::class, 'index'])->name('penjoki.group');
    Route::get('penjoki/group/chat/{id}', [PenjokiGroupController::class, 'chat'])->name('penjoki.group.chat');
    Route::get('penjoki/group/receive/{id}', [PenjokiGroupController::class, 'receive'])->name('penjoki.group.receive');
    Route::post('penjoki/group/chatadd', [PenjokiGroupController::class, 'store'])->name('penjoki.group.chatadd');

    Route::get('penjoki/order', [PenjokiOrderController::class, 'index'])->name('penjoki.order');
    Route::get('penjoki/order/getListData', [PenjokiOrderController::class, 'listData'])->name('penjoki.order.list');
    Route::get('penjoki/order/add', [PenjokiOrderController::class, 'create'])->name('penjoki.order.add');
    Route::get('penjoki/order/detail/{id}', [PenjokiOrderController::class, 'show'])->name('penjoki.order.detail');
    Route::post('penjoki/order/store', [PenjokiOrderController::class, 'store'])->name('penjoki.order.store');
    Route::get('penjoki/order/{id}', [PenjokiOrderController::class, 'edit'])->name('penjoki.order.edit');
    Route::put('penjoki/order/update/{id}', [PenjokiOrderController::class, 'update'])->name('penjoki.order.update');
    Route::get('penjoki/order/delete/{id}', [PenjokiOrderController::class, 'destroy'])->name('penjoki.order.delete');

    Route::get('penjoki/fileproject/getListData/{id}', [PenjokiFileProjectController::class, 'listData'])->name('penjoki.fileproject.list');
    Route::post('penjoki/fileproject/store', [PenjokiFileProjectController::class, 'store'])->name('penjoki.fileproject.store');
    Route::get('penjoki/fileproject/delete/{id}', [PenjokiFileProjectController::class, 'destroy'])->name('penjoki.fileproject.delete');

    // activities
    Route::get('penjoki/fileproject/activitiesTable/{id}', [ActivitiesController::class, 'activitiesTable'])->name('penjoki.fileproject.activity-table');
    Route::post('penjoki/fileproject/activity-store', [ActivitiesController::class, 'store'])->name('penjoki.fileproject.activity-store');
});

Route::group(['middleware' => ['xss', 'auth:pelanggan', 'role:pelanggan']], function () {

    Route::get('pelanggan/dashboard', [PelangganDashboardController::class, 'index'])->name('pelanggan.dashboard');

    Route::get('pelanggan/order', [PelangganOrderController::class, 'index'])->name('pelanggan.order');
    Route::get('pelanggan/order/getListData', [PelangganOrderController::class, 'listData'])->name('pelanggan.order.list');
    Route::get('pelanggan/order/detail/{id}', [PelangganOrderController::class, 'show'])->name('pelanggan.order.detail');
    Route::get('pelanggan/order/activities/{id}', [PelangganOrderController::class, 'activity'])->name('pelanggan.order.activities');

    Route::get('pelanggan/group', [PelangganGroupController::class, 'index'])->name('pelanggan.group');
    Route::get('pelanggan/group/chat/{id}', [PelangganGroupController::class, 'chat'])->name('pelanggan.group.chat');
    Route::get('pelanggan/group/receive/{id}', [PelangganGroupController::class, 'receive'])->name('pelanggan.group.receive');
    Route::post('pelanggan/group/chatadd', [PelangganGroupController::class, 'store'])->name('pelanggan.group.chatadd');

    Route::get('pelanggan/fileproject/getListData/{id}', [PelangganFileProjectController::class, 'listData'])->name('pelanggan.fileproject.list');
    Route::post('pelanggan/fileproject/store', [PelangganFileProjectController::class, 'store'])->name('pelanggan.fileproject.store');
    Route::get('pelanggan/fileproject/delete/{id}', [PelangganFileProjectController::class, 'destroy'])->name('pelanggan.fileproject.delete');
});
