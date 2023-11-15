<?php

namespace App\Http\Controllers;

use App\Models\DataMenu;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;

class LaporanProdukController extends Controller
{
    public function index()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('laporan-produk.index', compact('menu', 'roleuser'));
    }
}
