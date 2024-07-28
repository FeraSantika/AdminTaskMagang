<?php

namespace App\Http\Controllers;

use App\Models\DataDepo;
use App\Models\DataMenu;
use App\Models\AksesDepo;
use App\Models\AksesDistributor;
use App\Models\DataCustomer;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Models\DataDistributor;
use App\Models\DataKategoriCustomer;

class DataCustomerDistributorController extends Controller
{
    public function index()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $user_id =  auth()->user()->User_id;
        $distributor = AksesDistributor::where('user_id', $user_id)->value('distributor_id');

        $dtcustomer = DataCustomer::with('kategori', 'depo', 'distributor')->where('distributor_id', $distributor)->paginate(10);

        return view('customer-distributor.index', compact('menu', 'roleuser', 'dtcustomer'));
    }

    public function create()
    {
        $dtcustomer = DataCustomer::get();
        $prefix = 'CST';
        $length = 4;
        $lastcustomer = DataCustomer::orderBy('customer_id', 'desc')->first();
        if ($lastcustomer) {
            $lastId = (int) substr($lastcustomer->customer_kode, strlen($prefix));
        } else {
            $lastId = 0;
        }
        $nextId = $lastId + 1;
        $paddedId = str_pad($nextId, $length, '0', STR_PAD_LEFT);
        $customerCode = $prefix . $paddedId;

        $user_id =  auth()->user()->User_id;
        $distributor = AksesDistributor::where('user_id', $user_id)->with('distributor', 'depo')->get();

        $dtkategori = DataKategoriCustomer::get();
        $dtdepo = DataDepo::join('data_distributor', 'data_depo.distributor_id', '=', 'data_distributor.distributor_id')
            ->groupBy('data_distributor.distributor_nama')->get();
        $dtdistributor = DataDistributor::get();

        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        // dd($distributor);
        return view('customer-distributor.create', compact('dtcustomer', 'lastcustomer', 'customerCode', 'menu', 'roleuser', 'dtkategori', 'dtdepo', 'dtdistributor', 'distributor'));
    }

    // public function autocomplete(Request $request)
    // {
    //     $distributorId = $request->input('distributor_id');

    //     $depo = DataDepo::where('distributor_id', $distributorId)->get();

    //     return response()->json(['depo' => $depo]);
    // }

    public function store(Request $request)
    {
        $customer = DataCustomer::create([
            'customer_nama' => $request->nama,
            'customer_kode' => $request->kode,
            'kategori_customer_id' => $request->kategori,
            'depo_id' => $request->depo,
            'distributor_id' => $request->distributor,
            'customer_alamat' => $request->alamat,
            'customer_nomor_hp' => $request->nomor_hp,
            'latitude' => $request->latitude,
            'longtitude' => $request->longtitude,
        ]);

        $prefix = 'CST';
        $length = 4;
        $lastcustomer = DataCustomer::orderBy('customer_id', 'desc')->first();
        if ($lastcustomer) {
            $lastId = (int) substr($lastcustomer->customer_kode, strlen($prefix));
        } else {
            $lastId = 0;
        }

        $nextId = $lastId + 1;
        $paddedId = str_pad($nextId, $length, '0', STR_PAD_LEFT);
        $newcustomerCode = $prefix . $paddedId;

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data' => $customer,
            'new_kode' => $newcustomerCode
        ]);
    }

    public function edit($id)
    {
        $dtcustomer =  Datacustomer::where('customer_id', $id)->with('depo', 'distributor')->first();
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $user_id =  auth()->user()->User_id;
        $distributor = AksesDepo::where('user_id', $user_id)->with('depo.distributor')->get();

        $dtkategori = DataKategoriCustomer::get();
        $dtdepo = DataDepo::join('data_distributor', 'data_depo.distributor_id', '=', 'data_distributor.distributor_id')
            ->groupBy('data_distributor.distributor_nama')->get();
        $dtdistributor = DataDistributor::get();
        return view('customer-distributor.edit', compact('dtcustomer', 'menu', 'roleuser', 'dtkategori', 'dtdepo', 'dtdistributor', 'distributor'));
    }

    public function update(Request $request, $id)
    {
        $dtcustomer = [
            'customer_nama' => $request->nama,
            'customer_kode' => $request->kode,
            'kategori_customer_id' => $request->kategori,
            'depo_id' => $request->depo,
            'distributor_id' => $request->distributor,
            'customer_alamat' => $request->alamat,
            'customer_nomor_hp' => $request->nomor_hp,
            'latitude' => $request->latitude,
            'longtitude' => $request->longtitude,
        ];

        Datacustomer::where('customer_id', $id)->update($dtcustomer);

        return redirect()->route('customer-distributor')->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $dt = Datacustomer::where('customer_id', $id);
        $dt->delete();
        return redirect()->route('customer-distributor')->with('success', 'Data berhasil dihapus!');
    }

    public function search(Request $request)
    {
        $user_id =  auth()->user()->User_id;
        $distributor = AksesDistributor::where('user_id', $user_id)->value('distributor_id');

        $searchTerm = $request->get('cari');

        $data = DataCustomer::where('distributor_id', $distributor)
            ->where(function ($query) use ($searchTerm) {
                $query->where('customer_nama', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhereHas('kategori', function ($subquery) use ($searchTerm) {
                        $subquery->where('kategori_customer_nama', 'LIKE', '%' . $searchTerm . '%');
                    });
            })
            ->with('kategori', 'depo', 'distributor')
            ->get();

        return response()->json($data);
    }
}
