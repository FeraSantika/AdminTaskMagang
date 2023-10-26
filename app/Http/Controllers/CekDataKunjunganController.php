<?php

namespace App\Http\Controllers;

use App\Models\DataMenu;
use App\Models\DataUser;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Models\DataKunjungan;

class CekDataKunjunganController extends Controller
{
    public function index()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        $dtkunjungan = DataKunjungan::with('user', 'rute')->get();
        $dtsales = DataUser::where('Role_id', 4)->get();
        return view('cek_kunjungan.index', compact('menu', 'roleuser', 'dtkunjungan', 'dtsales'));
    }

    public function getData(Request $request)
    {
        // $pilihSales = $request->input('pilihSales');
        $pilihSales = $request->pilihSales;

        $dataTerfilter = DataKunjungan::with('user', 'rute')
            ->where('User_id', $pilihSales)
            ->get();

        return response()->json($dataTerfilter);
    }
}
