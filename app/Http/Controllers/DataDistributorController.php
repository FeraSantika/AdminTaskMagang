<?php

namespace App\Http\Controllers;

use App\Models\DataDistributor;
use App\Models\DataMenu;
use App\Models\DataRole;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;

class DataDistributorController extends Controller
{
    public function index()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        $dtDistributor = DataDistributor::get();
        return view('distributor.index', compact('menu', 'roleuser', 'dtDistributor'));
    }

    public function create()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('distributor.create', compact('menu', 'roleuser'));
    }

    public function store(Request $request)
    {
        $data = DataDistributor::create([
            'distributor_nama' => $request->nama
        ]);
        return redirect()->route('distributor')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->get();
        $distributor = DataDistributor::where('distributor_id', $id)->first();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('distributor.edit', compact('menu', 'distributor','roleuser'));
    }

    public function update(Request $request, $id)
    {
        DataDistributor::where('distributor_id', $id)->update([
            'distributor_nama' => $request->nama
        ]);
        return redirect()->route('distributor')->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $distributor = DataDistributor::where('distributor_id', $id);
        $distributor->delete();
        return redirect()->route('distributor')->with('success', 'Data berhasil dihapus!');
    }
}
