<?php

namespace App\Http\Controllers;

use App\Models\DataKategoriCustomer;
use App\Models\DataMenu;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;

class DataKategoriCustomerController extends Controller
{
    public function index()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        $dtkategori = DataKategoriCustomer::get();
        return view('kategori_customer.index', compact('menu', 'roleuser', 'dtkategori'));
    }

    public function create()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('kategori_customer.create', compact('menu', 'roleuser'));
    }

    public function store(Request $request)
    {
        DataKategoriCustomer::create([
            'kategori_customer_nama' => $request->nama,
        ]);
        return redirect()->route('kategori_customer');
    }

    public function edit($id)
    {
        $dtkategori = DataKategoriCustomer::where('kategori_customer_id', $id)->first();
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('kategori_customer.edit', compact('dtkategori', 'menu', 'roleuser'));
    }

    public function update(Request $request, $id)
    {
        DataKategoriCustomer::where('kategori_customer_id', $id)->update(['kategori_customer_nama' => $request->nama]);
        return redirect()->route('kategori_customer');
    }

    public function destroy($id)
    {
        DataKategoriCustomer::where('kategori_customer_id', $id)->delete();
        return redirect()->route('kategori_customer');
    }

    public function search(Request $request)
    {
        $searchTerm = $request->get('cari');

        $data = DataKategoriCustomer::where('nama_kategori', 'LIKE', '%' . $searchTerm . '%')
            ->get();

        return response()->json($data);
    }
}
