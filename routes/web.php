<?php

use App\Imports\DataKunjunganImport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DataDepoController;
use App\Http\Controllers\DataRuteController;
use App\Http\Controllers\AksesDepoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CekPesananController;
use App\Http\Controllers\DataProdukController;
use App\Http\Controllers\DataSatuanController;
use App\Http\Controllers\DataCustomerController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DataKunjunganController;
use App\Http\Controllers\LaporanProdukController;
use App\Http\Controllers\CekPesananDepoController;
use App\Http\Controllers\DataDistributorController;
use App\Http\Controllers\AksesDistributorController;
use App\Http\Controllers\CekDataKunjunganController;
use App\Http\Controllers\DataCustomerDepoController;
use App\Http\Controllers\LaporanKunjunganController;
use App\Http\Controllers\LaporanProdukDepoController;
use App\Http\Controllers\ListDataKunjunganController;
use App\Http\Controllers\DataKategoriCustomerController;
use App\Http\Controllers\LaporanKunjunganDepoController;

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
Route::get('/admin/home-sales', [HomeController::class, 'sales'])->name('sales.home');
Route::get('/admin/home-depo', [HomeController::class, 'depo'])->name('depo.home');

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
Route::get('/search/autocomplete_customer', [DataCustomerController::class, 'autocomplete'])->name('autocomplete_customer');

Route::get('/admin/customer-depo', [DataCustomerDepoController::class, 'index'])->name('customer-depo');
Route::get('/admin/customer-depo/create', [DataCustomerDepoController::class, 'create'])->name('customer-depo.create');
Route::post('/admin/customer-depo/store', [DataCustomerDepoController::class, 'store'])->name('customer-depo.store');
Route::get('/admin/customer-depo/edit/{id}', [DataCustomerDepoController::class, 'edit'])->name('customer-depo.edit');
Route::post('/admin/customer-depo/update/{id}', [DataCustomerDepoController::class, 'update'])->name('customer-depo.update');
Route::delete('/admin/customer-depo/destroy/{id}', [DataCustomerDepoController::class, 'destroy'])->name('customer-depo.destroy');
Route::delete('/admin/customer-depo/destroysearch/{id}', [DataCustomerDepoController::class, 'destroysearch'])->name('customer-depo.destroysearch');
Route::get('/search/customer-depo', [DataCustomerDepoController::class, 'search'])->name('search.customer-depo');
Route::get('/search/autocomplete_customer-depo', [DataCustomerDepoController::class, 'autocomplete'])->name('autocomplete_customer-depo');

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
Route::post('/admin/rute/import', [DataRuteController::class, 'import'])->name('rute.import');

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
Route::post('/admin/kunjungan/import', [DataKunjunganController::class, 'import'])->name('kunjungan.import');

Route::get('/admin/cek-kunjungan', [CekDataKunjunganController::class, 'index'])->name('cek-kunjungan');
Route::get('/admin/cek-kunjungan/get_data', [CekDataKunjunganController::class, 'getData'])->name('cek-kunjungan.get_data');
Route::get('/admin/cek-kunjungan/export-excel', [CekDataKunjunganController::class, 'exportExcel'])->name('cek-kunjungan.export-excel');
Route::get('/admin/cek-kunjungan/export-pdf', [CekDataKunjunganController::class, 'exportPDF'])->name('cek-kunjungan.export-pdf');

Route::get('/admin/list-kunjungan', [ListDataKunjunganController::class, 'index'])->name('list-kunjungan');
Route::get('/admin/list-kunjungan/detail/{id}', [ListDataKunjunganController::class, 'detail'])->name('list-kunjungan.detail');
Route::get('/admin/list-kunjungan/auto-complete', [ListDataKunjunganController::class, 'autocomplete'])->name('list-kunjungan.autocomplete');
Route::post('/admin/list-kunjungan/insert-list', [ListDataKunjunganController::class, 'insertlist'])->name('list-kunjungan.insert-list');
Route::get('/admin/list-kunjungan/destroy/{id}', [ListDataKunjunganController::class, 'destroy'])->name('list-kunjungan.destroy');
Route::post('/admin/list-kunjungan/store-list', [ListDataKunjunganController::class, 'storelist'])->name('list-kunjungan.store-list');
Route::post('/admin/list-kunjungan/update-list', [ListDataKunjunganController::class, 'updatelist'])->name('list-kunjungan.update-list');

Route::get('/admin/satuan', [DataSatuanController::class, 'index'])->name('satuan');
Route::get('/admin/satuan/create', [DataSatuanController::class, 'create'])->name('satuan.create');
Route::post('/admin/satuan/store', [DataSatuanController::class, 'store'])->name('satuan.store');
Route::get('/admin/satuan/edit/{id}', [DataSatuanController::class, 'edit'])->name('satuan.edit');
Route::post('/admin/satuan/update/{id}', [DataSatuanController::class, 'update'])->name('satuan.update');
Route::delete('/admin/satuan/destroy/{id}', [DataSatuanController::class, 'destroy'])->name('satuan.destroy');

Route::get('/admin/akses-depo', [AksesDepoController::class, 'index'])->name('akses-depo');
Route::get('/admin/akses-depo/create', [AksesDepoController::class, 'create'])->name('akses-depo.create');
Route::post('/admin/akses-depo/store', [AksesDepoController::class, 'store'])->name('akses-depo.store');
Route::get('/admin/akses-depo/edit/{id}', [AksesDepoController::class, 'edit'])->name('akses-depo.edit');
Route::post('/admin/akses-depo/update/{id}', [AksesDepoController::class, 'update'])->name('akses-depo.update');
Route::delete('/admin/akses-depo/destroy/{id}', [AksesDepoController::class, 'destroy'])->name('akses-depo.destroy');

Route::get('/admin/akses-distributor', [AksesDistributorController::class, 'index'])->name('akses-distributor');
Route::get('/admin/akses-distributor/create', [AksesDistributorController::class, 'create'])->name('akses-distributor.create');
Route::post('/admin/akses-distributor/store', [AksesDistributorController::class, 'store'])->name('akses-distributor.store');
Route::get('/admin/akses-distributor/edit/{id}', [AksesDistributorController::class, 'edit'])->name('akses-distributor.edit');
Route::post('/admin/akses-distributor/update/{id}', [AksesDistributorController::class, 'update'])->name('akses-distributor.update');
Route::delete('/admin/akses-distributor/destroy/{id}', [AksesDistributorController::class, 'destroy'])->name('akses-distributor.destroy');

Route::get('/admin/laporan-kunjungan', [LaporanKunjunganController::class, 'index'])->name('laporan-kunjungan');
Route::get('/admin/laporan-kunjungan/get_data', [LaporanKunjunganController::class, 'getData'])->name('laporan-kunjungan.get_data');

Route::get('/admin/laporan-kunjungan-depo', [LaporanKunjunganDepoController::class, 'index'])->name('laporan-kunjungan-depo');
Route::get('/admin/laporan-kunjungan-depo/get_data', [LaporanKunjunganDepoController::class, 'getData'])->name('laporan-kunjungan-depo.get_data');

Route::get('/admin/laporan-produk', [LaporanProdukController::class, 'index'])->name('laporan-produk');
Route::get('/admin/laporan-produk/get_data', [LaporanProdukController::class, 'getData'])->name('laporan-produk.get_data');
Route::get('/admin/laporan-produk/export-pdf', [LaporanProdukController::class, 'exportPDF'])->name('laporan-produk.export-pdf');
Route::get('/admin/laporan-produk/export-excel', [LaporanProdukController::class, 'exportExcel'])->name('laporan-produk.export-excel');

Route::get('/admin/laporan-produk-depo', [LaporanProdukDepoController::class, 'index'])->name('laporan-produk-depo');
Route::get('/admin/laporan-produk-depo/get_data', [LaporanProdukDepoController::class, 'getData'])->name('laporan-produk-depo.get_data');
Route::get('/admin/laporan-produk-depo/export-pdf', [LaporanProdukDepoController::class, 'exportPDF'])->name('laporan-produk-depo.export-pdf');
Route::get('/admin/laporan-produk-depo/export-excel', [LaporanProdukDepoController::class, 'exportExcel'])->name('laporan-produk-depo.export-excel');

Route::get('/admin/cek-pesanan', [CekPesananController::class, 'index'])->name('cek-pesanan');
Route::get('/admin/cek-pesanan/export-pdf', [CekPesananController::class, 'exportPDF'])->name('cek-pesanan.export-pdf');
Route::get('/admin/cek-pesanan/export-excel', [CekPesananController::class, 'exportExcel'])->name('cek-pesanan.export-excel');

Route::get('/admin/cek-pesanan-depo', [CekPesananDepoController::class, 'index'])->name('cek-pesanan-depo');
Route::get('/admin/cek-pesanan-depo/export-pdf', [CekPesananDepoController::class, 'exportPDF'])->name('cek-pesanan-depo.export-pdf');
Route::get('/admin/cek-pesanan-depo/export-excel', [CekPesananDepoController::class, 'exportExcel'])->name('cek-pesanan-depo.export-excel');

