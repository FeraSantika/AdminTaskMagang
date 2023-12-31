<?php

namespace App\Http\Controllers;

use App\Models\DataMenu;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Models\DataDetailRute;
use App\Models\DataSatuan;

class DataSatuanController extends Controller
{
    public function index()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        $dtsatuan = DataSatuan::get();

        return view('satuan.index', compact('menu', 'roleuser', 'dtsatuan'));
    }

    public function create()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('satuan.create', compact('menu', 'roleuser'));
    }

    public function store(Request $request)
    {
        DataSatuan::create([
            'satuan_nama' => $request->nama
        ]);
        return redirect()->route('satuan')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->get();
        $satuan = Datasatuan::where('satuan_id', $id)->first();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('satuan.edit', compact('menu', 'satuan','roleuser'));
    }

    public function update(Request $request, $id)
    {
        Datasatuan::where('satuan_id', $id)->update([
            'satuan_nama' => $request->nama
        ]);
        return redirect()->route('satuan')->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $satuan = Datasatuan::where('satuan_id', $id);
        $satuan->delete();
        return redirect()->route('satuan')->with('success', 'Data berhasil dihapus!');
    }
}
