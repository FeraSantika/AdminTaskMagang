<?php

use App\Models\DataDetailRute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DataDepoController;
use App\Http\Controllers\DataRuteController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DataProdukController;
use App\Http\Controllers\DataCustomerController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DataKunjunganController;
use App\Http\Controllers\DataDetailRuteController;
use App\Http\Controllers\DataDistributorController;
use App\Http\Controllers\CekDataKunjunganController;
use App\Http\Controllers\DataKategoriCustomerController;

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

Route::get('/admin/customer', [DataCustomerController::class, 'index'])->name('customer');
Route::get('/admin/customer/create', [DataCustomerController::class, 'create'])->name('customer.create');
Route::post('/admin/customer/store', [DataCustomerController::class, 'store'])->name('customer.store');
Route::get('/admin/customer/edit/{id}', [DataCustomerController::class, 'edit'])->name('customer.edit');
Route::post('/admin/customer/update/{id}', [DataCustomerController::class, 'update'])->name('customer.update');
Route::delete('/admin/customer/destroy/{id}', [DataCustomerController::class, 'destroy'])->name('customer.destroy');
Route::delete('/admin/customer/destroysearch/{id}', [DataCustomerController::class, 'destroysearch'])->name('customer.destroysearch');
Route::get('/search/customer', [DataCustomerController::class, 'search'])->name('search.customer');

Route::get('/admin/kategori_customer', [DataKategoriCustomerController::class, 'index'])->name('kategori_customer');
Route::get('/admin/kategori_customer/create', [DataKategoriCustomerController::class, 'create'])->name('kategori_customer.create');
Route::post('/admin/kategori_customer/store', [DataKategoriCustomerController::class, 'store'])->name('kategori_customer.store');
Route::get('/admin/kategori_customer/edit/{id}', [DataKategoriCustomerController::class, 'edit'])->name('kategori_customer.edit');
Route::post('/admin/kategori_customer/update/{id}', [DataKategoriCustomerController::class, 'update'])->name('kategori_customer.update');
Route::delete('/admin/kategori_customer/destroy/{id}', [DataKategoriCustomerController::class, 'destroy'])->name('kategori_customer.destroy');
Route::get('/search/kategori_customer', [DataKategoriCustomerController::class, 'search'])->name('search.kategori_customer');

Route::get('/admin/rute', [DataRuteController::class, 'index'])->name('rute');
Route::get('/admin/rute/create', [DataRuteController::class, 'create'])->name('rute.create');
Route::post('/admin/rute/store', [DataRuteController::class, 'store'])->name('rute.store');
Route::get('/admin/rute/edit/{id}', [DataRuteController::class, 'edit'])->name('rute.edit');
Route::post('/admin/rute/update/{id}', [DataRuteController::class, 'update'])->name('rute.update');
Route::delete('/admin/rute/destroy/{id}', [DataRuteController::class, 'destroy'])->name('rute.destroy');

Route::get('/admin/produk', [DataProdukController::class, 'index'])->name('produk');
Route::get('/admin/produk/create', [DataProdukController::class, 'create'])->name('produk.create');
Route::post('/admin/produk/store', [DataProdukController::class, 'store'])->name('produk.store');
Route::get('/admin/produk/edit/{id}', [DataProdukController::class, 'edit'])->name('produk.edit');
Route::post('/admin/produk/update/{id}', [DataProdukController::class, 'update'])->name('produk.update');
Route::delete('/admin/produk/destroy/{id}', [DataProdukController::class, 'destroy'])->name('produk.destroy');

Route::get('/admin/kunjungan', [DataKunjunganController::class, 'index'])->name('kunjungan');
Route::get('/admin/kunjungan/create', [DataKunjunganController::class, 'create'])->name('kunjungan.create');
Route::post('/admin/kunjungan/store', [DataKunjunganController::class, 'store'])->name('kunjungan.store');
Route::get('/admin/kunjungan/edit/{id}', [DataKunjunganController::class, 'edit'])->name('kunjungan.edit');
Route::post('/admin/kunjungan/update/{id}', [DataKunjunganController::class, 'update'])->name('kunjungan.update');
Route::delete('/admin/kunjungan/destroy/{id}', [DataKunjunganController::class, 'destroy'])->name('kunjungan.destroy');
Route::get('/admin/kunjungan/detail/{id}', [DataKunjunganController::class, 'detail'])->name('kunjungan.detail');

Route::get('/admin/cek-kunjungan', [CekDataKunjunganController::class, 'index'])->name('cek-kunjungan');
Route::get('/admin/cek-kunjungan/get_data', [CekDataKunjunganController::class, 'getData'])->name('cek-kunjungan.get_data');