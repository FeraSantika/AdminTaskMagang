<?php

namespace App\Http\Controllers;

use App\Models\DataMenu;
use App\Models\DataRute;
use App\Models\DataUser;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Models\DataKunjungan;
use App\Models\DataDetailRute;
use App\Imports\DataKunjunganImport;
use Maatwebsite\Excel\Facades\Excel;

class DataKunjunganController extends Controller
{
    public function index()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        $dtkunjungan = DataKunjungan::with('user', 'rute')->paginate(10);
        return view('kunjungan.index', compact('menu', 'roleuser', 'dtkunjungan'));
    }

    public function create()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $dtuser = DataUser::where('Role_id', 4)->get();
        $dtrute = DataRute::get();
        return view('kunjungan.create', compact('menu', 'roleuser', 'dtuser', 'dtrute'));
    }

    public function store(Request $request)
    {
        DataKunjungan::create([
            'user_id' => $request->user,
            'rute_id' => $request->rute,
            'kunjungan_tanggal' => $request->tanggal
        ]);
        return redirect()->route('kunjungan')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $kunjungan = Datakunjungan::where('kunjungan_id', $id)->first();
        $dtuser = DataUser::get();
        $dtrute = DataRute::get();
        return view('kunjungan.edit', compact('menu', 'kunjungan', 'roleuser', 'dtuser', 'dtrute'));
    }

    public function update(Request $request, $id)
    {
        Datakunjungan::where('kunjungan_id', $id)->update([
            'user_id' => $request->user,
            'rute_id' => $request->rute,
            'kunjungan_tanggal' => $request->tanggal
        ]);
        return redirect()->route('kunjungan')->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $kunjungan = Datakunjungan::where('kunjungan_id', $id);
        $kunjungan->delete();
        return redirect()->route('kunjungan')->with('success', 'Data berhasil dihapus!');
    }

    public function detail($id)
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $kunjungan =  DataKunjungan::where('kunjungan_id', $id)->first();
        $dtrute = DataDetailRute::where('rute_id', $kunjungan->rute_id)->with('customer')->get();
        return view('kunjungan.detail', compact('kunjungan', 'menu', 'roleuser', 'dtrute'));
    }

    public function import(Request $request)
    {
        Excel::import(new DataKunjunganImport, $request->file('file'));
        return redirect()->back()->with('success', 'Data berhasil diimpor!');
    }

    public function search(Request $request)
    {
        $searchTerm = $request->get('cari');

        $data = DataKunjungan::WhereHas('user', function ($query) use ($searchTerm) {
                $query->where('User_name', 'LIKE', '%' . $searchTerm . '%');
            })
            ->with('user', 'rute')->get();

        return response()->json($data);
    }
}
