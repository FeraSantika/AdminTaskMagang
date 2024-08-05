<?php

namespace App\Http\Controllers;

use App\Models\DataMenu;
use App\Models\DataSatuan;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class DataSatuanController extends Controller
{
    public function index()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        $dtsatuan = DataSatuan::get();

        return view('satuan.index', compact('menu', 'roleuser', 'dtsatuan'));
    }

    public function create()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
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

    public function edit($encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $satuan = Datasatuan::where('satuan_id', $id)->first();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('satuan.edit', compact('menu', 'satuan', 'roleuser'));
    }

    public function update(Request $request, $encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);
        Datasatuan::where('satuan_id', $id)->update([
            'satuan_nama' => $request->nama
        ]);
        return redirect()->route('satuan')->with('success', 'Data berhasil diubah!');
    }

    public function destroy($encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);
        $satuan = Datasatuan::where('satuan_id', $id);
        $satuan->delete();
        return redirect()->route('satuan')->with('success', 'Data berhasil dihapus!');
    }
}
