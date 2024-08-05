<?php

namespace App\Http\Controllers;

use App\Models\DataDepo;
use App\Models\DataMenu;
use App\Models\DataUser;
use App\Models\AksesDepo;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class AksesDepoController extends Controller
{
    public function index()
    {
        $dtaksesdepo = AksesDepo::with('user', 'depo')->get();
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('aksesdepo.index', compact('dtaksesdepo', 'menu', 'roleuser'));
    }

    public function create()
    {
        $dtuser = DataUser::where('Role_id', 6)->get();
        $dtdepo = DataDepo::get();
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        return view('aksesdepo.create', compact('dtuser', 'dtdepo', 'menu', 'roleuser'));
    }

    public function store(Request $request)
    {
        AksesDepo::create([
            'depo_id' => $request->depo,
            'user_id' => $request->user
        ]);

        return redirect()->route('akses-depo');
    }

    public function edit($encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);
        $dtuser = DataUser::where('Role_id', 2)->get();
        $dtdepo = Datadepo::get();
        $dtaksesdepo = AksesDepo::where('akses_depo_id', $id)->with('user', 'depo')->first();
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('aksesdepo.edit', compact('dtaksesdepo', 'dtuser', 'dtdepo', 'roleuser', 'menu'));
    }

    public function update(Request $request, $encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);
        AksesDepo::where('akses_depo_id', $id)->update([
            'depo_id' => $request->depo,
            'user_id' => $request->user
        ]);
        return redirect()->route('akses-depo');
    }

    public function destroy($encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);
        $dtaksesdepo = AksesDepo::where('akses_depo_id', $id);
        $dtaksesdepo->delete();
        return redirect()->route('akses-depo');
    }
}
