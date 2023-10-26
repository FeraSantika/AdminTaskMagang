<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\DataMenu;
use App\Models\DataUser;
use App\Models\DataBarang;
use App\Models\DataPasien;
use App\Models\DataPoli;
use App\Models\Verifytoken;
use App\Models\DataRoleMenu;
use App\Models\DataSupplier;
use Illuminate\Http\Request;
use App\Models\ListDaftarObat;
use App\Models\PendaftaranPasien;
use Illuminate\Support\Facades\DB;
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
        return view('home', compact('roleuser', 'menu'));
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