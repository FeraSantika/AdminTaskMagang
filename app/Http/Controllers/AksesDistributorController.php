<?php

namespace App\Http\Controllers;

use App\Models\DataMenu;
use App\Models\DataUser;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Models\DataDistributor;
use App\Models\AksesDistributor;
use Illuminate\Support\Facades\Crypt;

class AksesDistributorController extends Controller
{
    public function index()
    {
        $dtAksesDistributor = AksesDistributor::with('user', 'distributor')->get();
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('aksesdistributor.index', compact('dtAksesDistributor', 'menu', 'roleuser'));
    }

    public function create()
    {
        $dtuser = DataUser::where('Role_id', 7)->get();
        $dtdistributor = DataDistributor::get();
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        return view('aksesdistributor.create', compact('dtuser', 'dtdistributor', 'menu', 'roleuser'));
    }

    public function store(Request $request)
    {
        AksesDistributor::create([
            'distributor_id' => $request->distributor,
            'user_id' => $request->user
        ]);

        return redirect()->route('akses-distributor');
    }

    public function edit($encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);
        $dtuser = DataUser::where('Role_id', 3)->get();
        $dtdistributor = Datadistributor::get();
        $dtaksesdistributor = AksesDistributor::where('akses_distributor_id', $id)->with('user', 'distributor')->first();
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('aksesdistributor.edit', compact('dtaksesdistributor', 'dtuser', 'dtdistributor', 'roleuser', 'menu'));
    }

    public function update(Request $request, $encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);
        AksesDistributor::where('akses_distributor_id', $id)->update([
            'distributor_id' => $request->distributor,
            'user_id' => $request->user
        ]);
        return redirect()->route('akses-distributor');
    }

    public function destroy($encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);
        $dtAksesDistributor = AksesDistributor::where('akses_distributor_id', $id);
        $dtAksesDistributor->delete();
        return redirect()->route('akses-distributor');
    }
}
