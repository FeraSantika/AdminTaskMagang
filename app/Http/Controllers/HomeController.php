<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\DataMenu;
use App\Models\DataPoli;
use App\Models\DataUser;
use App\Models\DataBarang;
use App\Models\DataPasien;
use App\Models\DataProduk;
use App\Models\Verifytoken;
use App\Models\DataCustomer;
use App\Models\DataRoleMenu;
use App\Models\DataSupplier;
use Illuminate\Http\Request;
use App\Models\DataKunjungan;
use App\Models\DataDetailRute;
use App\Models\ListDaftarObat;
use App\Models\PendaftaranPasien;
use Illuminate\Support\Facades\DB;
use App\Models\TransaksiDataProduk;
use App\Models\PendaftaranPasienInap;
use App\Models\Transaksi_barang_masuk;
use App\Models\Transaksi_barang_keluar;
use App\Models\ListDaftarObatPasienInap;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $distributor = DataUser::where('Role_id', 3)->count();
        $depo = DataUser::where('Role_id', 2)->count();
        $produk = DataProduk::count();
        $kunjungan = DataKunjungan::whereDate('kunjungan_tanggal', today())->count();
        $sales = DataUser::where('Role_id', 4)->count();
        $admin = DataUser::where('Role_id', 1)->count();
        $customer = DataCustomer::count();
        $pengguna = DataUser::count();

        return view('home', compact('roleuser', 'menu', 'distributor', 'depo', 'produk', 'kunjungan', 'sales', 'admin', 'customer', 'pengguna'));
    }

    public function sales()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $sales = auth()->user()->User_id;
        $today = now()->format('Y-m-d');

        $kunjungan = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
            ->where('data_kunjungan.user_id', $sales)
            ->whereDate('data_kunjungan.kunjungan_tanggal', $today)
            ->with('rute', 'customer')
            ->count();
        $pesanan = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
            ->whereDate('data_kunjungan.kunjungan_tanggal', $today)
            ->where('data_detail_rute.status', '=', 'Pesan')
            ->with('rute', 'customer')
            ->count();
        $tokoTutup = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
            ->whereDate('data_kunjungan.kunjungan_tanggal', $today)
            ->where('data_detail_rute.status', '=', 'Toko Tutup')
            ->with('rute', 'customer')
            ->count();
        $transaksiSelesai = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
            ->where('data_kunjungan.user_id', $sales)
            ->whereDate('data_detail_rute.updated_at', $today)
            ->where('data_detail_rute.status', '=', 'Selesai')
            ->with('rute', 'customer')
            ->count();
        // dd($pesanan);
        return view('home-sales', compact('roleuser', 'menu', 'kunjungan', 'pesanan', 'tokoTutup', 'transaksiSelesai'));
    }

    public function depo()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $depo = auth()->user()->User_id;
        $today = now()->format('Y-m-d');

        $kunjungan = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
            ->where('data_kunjungan.user_id', $depo)
            ->whereDate('data_kunjungan.kunjungan_tanggal', $today)
            ->with('rute', 'customer')
            ->count();
        $pesanan = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
            ->whereDate('data_kunjungan.kunjungan_tanggal', $today)
            ->where('data_detail_rute.status', '=', 'Pesan')
            ->with('rute', 'customer')
            ->count();
        $tokoTutup = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
            ->whereDate('data_kunjungan.kunjungan_tanggal', $today)
            ->where('data_detail_rute.status', '=', 'Toko Tutup')
            ->with('rute', 'customer')
            ->count();
        $transaksiSelesai = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
            ->where('data_kunjungan.user_id', $depo)
            ->whereDate('data_detail_rute.updated_at', $today)
            ->where('data_detail_rute.status', '=', 'Selesai')
            ->with('rute', 'customer')
            ->count();

        return view('home-depo', compact('roleuser', 'menu', 'kunjungan', 'pesanan', 'tokoTutup', 'transaksiSelesai'));
    }

    // public function verifyaccount(){
    //     return view('otp_verification');
    // }

    // public function useractivation(Request $request){
    //     $get_token = $request->token;
    //     $get_token = Verifytoken::where('token', $get_token)->first();

    //     if($get_token){
    //         $get_token->activated = 1;
    //         $get_token->save();
    //         $user = User::where('email', $get_token->email)->first();
    //         $user->activated = 1;
    //         $user->save();
    //         $getting_token = Verifytoken::where('token', $get_token->token)->first();
    //         $getting_token->delete();
    //         return redirect('/home')->with('activated', 'Your Account has been activated successfully');
    //     }else{
    //         return redirect('/verify-account')->with('incorrect', 'Your OTP is Invalid please check your email once');
    //     }
    // }

    // public function tampil() {
    //     return view('dashboard-analytics');
    // }

    // public function sidebar()
    // {
    //     $menus = DataMenu::all();
    //     return view('layouts.sidebar', compact('menus'));
    // }
}
