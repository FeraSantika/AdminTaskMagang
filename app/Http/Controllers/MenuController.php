<?php

namespace App\Http\Controllers;

use App\Models\DataMenu;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use GuzzleHttp\Promise\Create;
use Dflydev\DotAccessData\Data;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index()
    {
        $dtMenu = DataMenu::leftJoin('data_menu as subMenu', 'data_menu.Menu_sub', '=', 'subMenu.Menu_id')
            ->select('subMenu.Menu_name as submenu_name', 'data_menu.*')
            ->paginate(10);
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('menu.menu', compact('dtMenu', 'menu', 'roleuser'));
    }

    public function create()
    {
        $dtMenu = DataMenu::select('*')->where('Menu_category', 'Master Menu')->get();
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('menu.create', compact('dtMenu', 'menu', 'roleuser'));
    }

    public function store(Request $request)
    {
        $menuCategory = $request->category;
        $menuSub = $menuCategory === 'Master Menu' ? null : $request->submenu;
        $result = DataMenu::insert([
            'Menu_name' => $request->name,
            'Menu_link' => $request->link,
            'Menu_category' => $menuCategory,
            'Menu_sub' => $menuSub,
            'Menu_position' => $request->position,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        if ($result) {
            return redirect()->route('menu');
        } else {
            return $this->create();
        }
    }

    public function edit($Menu_id)
    {
        $dtMenu = DataMenu::where('Menu_id', $Menu_id)->first();
        $menu = DataMenu::where('Menu_category', 'Master Menu')
        ->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('menu.edit', compact('dtMenu', 'menu', 'roleuser'));
    }

    public function update(Request $request, $Menu_id)
    {
        $menuCategory = $request->category;
        $menuSub = $menuCategory === 'Master Menu' ? null : $request->submenu;
        DataMenu::where('Menu_id', $Menu_id)->update([
            'Menu_name' => $request->name,
            'Menu_link' => $request->link,
            'Menu_category' => $menuCategory,
            'Menu_sub' => $menuSub,
            'Menu_position' => $request->position,
            'updated_at' => now(),
        ]);
        return redirect()->route('menu')->with('success', 'Menu edited successfully');
    }

    public function destroy($Menu_id)
    {
        $menu = DataMenu::where('Menu_id', $Menu_id);
        $menu->delete();
        return redirect()->route('menu')->with('success', 'Menu deleted successfully');
    }
}
