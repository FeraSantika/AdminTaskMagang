<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LabController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PoliController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\AntrianController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AksesLabController;
use App\Http\Controllers\DataDepoController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TindakanController;
use App\Http\Controllers\AksespoliController;
use App\Http\Controllers\HomeKasirController;
use App\Http\Controllers\KamarInapController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeDokterController;
use App\Http\Controllers\RumahsakitController;
use App\Http\Controllers\TindakanLabController;
use App\Http\Controllers\HomeApotekerController;
use App\Http\Controllers\JadwalDokterController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeAnalisLabController;
use App\Http\Controllers\TransaksiObatController;
use App\Http\Controllers\DataDistributorController;
use App\Http\Controllers\HomeResepsionisController;
use App\Http\Controllers\CekRiwayatPasienController;
use App\Http\Controllers\ListdaftarpasienController;
use App\Http\Controllers\ListRujukanPasienController;
use App\Http\Controllers\LaporanAntrianObatController;
use App\Http\Controllers\LaporanAntrianDokterController;
use App\Http\Controllers\LaporanObatRawatInapController;
use App\Http\Controllers\ListdaftarpasienInapController;
use App\Http\Controllers\LaporanHasilRawatInapController;
use App\Http\Controllers\LaporanObatRawatJalanController;
use App\Http\Controllers\ListRujukanPasienInapController;
use App\Http\Controllers\PendaftaranPasienInapController;
use App\Http\Controllers\LaporanHasilRawatJalanController;
use App\Http\Controllers\LaporanPasienRawatInapController;
use App\Http\Controllers\PendaftaranPasienJalanController;
use App\Http\Controllers\LaporanKartuAntrianObatController;
use App\Http\Controllers\LaporanPasienRawatJalanController;
use App\Http\Controllers\LaporanKartuAntrianDokterController;
use App\Http\Controllers\TransaksiPembayaranRawatInapController;
use App\Http\Controllers\TransaksiPembayaranRawatJalanController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('logout', [LoginController::class, 'logout']);
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('Adminlogin');
Route::get('/admin/register', [RegisterController::class, 'showRegisterForm'])->name('Adminregister');

Route::get('/admin/home', [HomeController::class, 'index'])->name('admin.home');

Route::get('/tampil', [App\Http\Controllers\HomeController::class, 'tampil'])->name('tampil');
Route::get('/admin/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('/admin/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::get('/profile/edit-password', [ProfileController::class, 'editPassword'])->name('profile.edit-password');
Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

Route::get('/admin/role', [RoleController::class, 'index'])->name('role');
Route::get('/admin/role/create', [RoleController::class, 'create'])->name('role.create');
Route::post('/admin/role/store', [RoleController::class, 'store'])->name('role.store');
Route::get('/admin/role/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
Route::post('/admin/role/update/{id}', [RoleController::class, 'update'])->name('role.update');
Route::delete('/admin/role/destroy/{id}', [RoleController::class, 'destroy'])->name('role.destroy');

Route::get('/admin/user', [UserController::class, 'index'])->name('user');
Route::get('/admin/user/create', [UserController::class, 'create'])->name('user.create');
Route::post('/admin/user/store', [UserController::class, 'store'])->name('user.store');
Route::get('/admin/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
Route::post('/admin/user/update/{id}', [UserController::class, 'update'])->name('user.update');
Route::delete('/admin/user/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');

Route::get('/admin/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/admin/menu/create', [MenuController::class, 'create'])->name('menu.create');
Route::post('/admin/menu/store', [MenuController::class, 'store'])->name('menu.store');
Route::get('/admin/menu/edit/{id}', [MenuController::class, 'edit'])->name('menu.edit');
Route::post('/admin/menu/update/{id}', [MenuController::class, 'update'])->name('menu.update');
Route::delete('/admin/menu/destroy/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');

Route::get('/admin/distributor', [DataDistributorController::class, 'index'])->name('distributor');
Route::get('/admin/distributor/create', [DataDistributorController::class, 'create'])->name('distributor.create');
Route::post('/admin/distributor/store', [DataDistributorController::class, 'store'])->name('distributor.store');
Route::get('/admin/distributor/edit/{id}', [DataDistributorController::class, 'edit'])->name('distributor.edit');
Route::post('/admin/distributor/update/{id}', [DataDistributorController::class, 'update'])->name('distributor.update');
Route::delete('/admin/distributor/destroy/{id}', [DataDistributorController::class, 'destroy'])->name('distributor.destroy');

Route::get('/admin/depo', [DataDepoController::class, 'index'])->name('depo');
Route::get('/admin/depo/create', [DataDepoController::class, 'create'])->name('depo.create');
Route::post('/admin/depo/store', [DataDepoController::class, 'store'])->name('depo.store');
Route::get('/admin/depo/edit/{id}', [DataDepoController::class, 'edit'])->name('depo.edit');
Route::post('/admin/depo/update/{id}', [DataDepoController::class, 'update'])->name('depo.update');
Route::delete('/admin/depo/destroy/{id}', [DataDepoController::class, 'destroy'])->name('depo.destroy');
