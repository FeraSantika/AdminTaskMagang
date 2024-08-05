<?php

namespace App\Http\Controllers;

use App\Models\DataDepo;
use App\Models\DataMenu;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Models\DataDistributor;
use Illuminate\Support\Facades\Crypt;

class DataDepoController extends Controller
{
    public function index()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        $dtDepo = DataDepo::with('distributor')->get();
        return view('depo.index', compact('menu', 'roleuser', 'dtDepo'));
    }

    public function create()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        $distributor = DataDistributor::get();
        return view('depo.create', compact('menu', 'roleuser', 'distributor'));
    }

    public function store(Request $request)
    {
        DataDepo::create([
            'distributor_id' => $request->distributor,
            'depo_nama' => $request->nama
        ]);
        return redirect()->route('depo')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);
        $menu = DataMenu::where('Menu_category', 'Master Menu')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        $depo = DataDepo::where('depo_id', $id)->first();
        $distributor = DataDistributor::get();
        return view('depo.edit', compact('menu', 'depo', 'roleuser', 'distributor'));
    }

    public function update(Request $request, $encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);
        DataDepo::where('depo_id', $id)->update([
            'distributor_id' => $request->distributor,
            'depo_nama' => $request->nama
        ]);
        return redirect()->route('depo')->with('success', 'Data berhasil diupdate!');
    }

    public function destroy($encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);
        $depo = DataDepo::where('depo_id', $id);
        $depo->delete();
        return redirect()->route('depo')->with('success', 'Data berhasil dihapus!');
    }
}
