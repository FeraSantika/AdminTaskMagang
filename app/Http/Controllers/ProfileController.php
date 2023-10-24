<?php

namespace App\Http\Controllers;

use App\Models\DataMenu;
use App\Models\DataRole;
use App\Models\DataUser;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        $dtUser = DataUser::with('role')->where('User_id', $user->User_id)->first();
        $dtRole = DataRole::all();
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('profile.edit', compact('user', 'dtRole', 'dtUser', 'menu', 'roleuser'));
    }


    public function update(Request $request)
    {
        $user = Auth::user()->User_id;
        $userData = [
            'User_name' => $request->username,
            'User_email' => $request->email,
            'User_gender' => $request->gender,
        ];

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $destinationPath = 'images/';
            $filename = date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $path = $destinationPath . $filename;
            $userData['User_photo'] = $path;
        }
        DataUser::where('User_id', $user)->update($userData);
        return redirect()->route('admin.home');
    }

    public function editPassword()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('profile.edit-password', compact('menu', 'roleuser'));
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user()->User_id;

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        DataUser::where('User_id', $user)->update([
            'User_password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('admin.home');
    }
}
