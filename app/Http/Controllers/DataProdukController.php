<?php

namespace App\Http\Controllers;

use App\Models\DataMenu;
use App\Models\DataProduk;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class DataProdukController extends Controller
{
    public function index()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $dtproduk = DataProduk::get();
        return view('produk.index', compact('menu', 'roleuser', 'dtproduk'));
    }

    public function create()
    {
        $dtproduk = DataProduk::get();
        $prefix = 'PRD';
        $length = 4;
        $lastproduk = DataProduk::orderBy('produk_id', 'desc')->first();
        if ($lastproduk) {
            $lastId = (int) substr($lastproduk->produk_kode, strlen($prefix));
        } else {
            $lastId = 0;
        }
        $nextId = $lastId + 1;
        $paddedId = str_pad($nextId, $length, '0', STR_PAD_LEFT);
        $produkCode = $prefix . $paddedId;

        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('produk.create', compact('dtproduk', 'lastproduk', 'produkCode', 'menu', 'roleuser'));
    }


    public function store(Request $request)
    {
        $produk = DataProduk::create([
            'produk_nama' => $request->nama,
            'produk_kode' => $request->kode,
        ]);

        $prefix = 'PRD';
        $length = 4;
        $lastproduk = DataProduk::orderBy('produk_id', 'desc')->first();
        if ($lastproduk) {
            $lastId = (int) substr($lastproduk->produk_kode, strlen($prefix));
        } else {
            $lastId = 0;
        }

        $nextId = $lastId + 1;
        $paddedId = str_pad($nextId, $length, '0', STR_PAD_LEFT);
        $newprodukCode = $prefix . $paddedId;

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data' => $produk,
            'new_kode' => $newprodukCode
        ]);
    }

    public function edit($encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);
        $produk =  Dataproduk::where('produk_id', $id)->first();
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        return view('produk.edit', compact('produk', 'menu', 'roleuser'));
    }

    public function update(Request $request, $encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);
        $dtproduk = [
            'produk_nama' => $request->nama,
            'produk_kode' => $request->kode,
        ];

        Dataproduk::where('produk_id', $id)->update($dtproduk);

        return redirect()->route('produk')->with('success', 'Data berhasil diubah!');
    }

    public function destroy($encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);
        $dt = Dataproduk::where('produk_id', $id);
        $dt->delete();
        return redirect()->route('produk')->with('success', 'Data berhasil dihapus!');
    }
}
