<?php

namespace App\Http\Controllers;

use App\Models\DataDepo;
use App\Models\DataMenu;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Models\DataDistributor;

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
        return redirect()->route('depo')->with('success', 'Data stored successfully');
    }

    public function edit($id)
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        $depo = DataDepo::where('depo_id', $id)->first();
        $distributor = DataDistributor::get();
        return view('depo.edit', compact('menu', 'depo', 'roleuser', 'distributor'));
    }

    public function update(Request $request, $id)
    {
        DataDepo::where('depo_id', $id)->update([
            'distributor_id' => $request->distributor,
            'depo_nama' => $request->nama
        ]);
        return redirect()->route('depo')->with('success', 'Data stored successfully');
    }

    public function destroy($id)
    {
        $depo = DataDepo::where('depo_id', $id);
        $depo->delete();
        return redirect()->route('depo')->with('success', 'Role deleted successfully');
    }
}
