<?php

namespace App\Http\Controllers;

use App\Models\DataMenu;
use App\Models\DataRute;
use App\Models\DataCustomer;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Models\DataDetailRute;
use App\Imports\DataRuteImport;
use Maatwebsite\Excel\Facades\Excel;

class DataRuteController extends Controller
{
    public function index()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();
        $dtdetailrute = DataDetailRute::with('rute', 'customer')->get();
        $groupedData = [];

        foreach ($dtdetailrute as $item) {
            $ruteName = $item->rute->rute_nama;
            $customerName = $item->customer->customer_nama;

            if (!isset($groupedData[$ruteName])) {
                $groupedData[$ruteName] = [];
            }

            $groupedData[$ruteName][] = $customerName;
        }
        return view('rute.index', compact('menu', 'roleuser', 'dtdetailrute', 'groupedData'));
    }

    public function create()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $dtcustomer = DataCustomer::get();
        return view('rute.create', compact('menu', 'roleuser', 'dtcustomer'));
    }

    public function store(Request $request)
    {
        $dtrute = DataRute::create([
            'rute_nama' => $request->nama
        ]);

        $customer_kode = $request->customer;

        foreach ($customer_kode as $kode) {
            DataDetailRute::create([
                'rute_id' => $dtrute->id,
                'customer_kode' => $kode,
                'status'=>'',
            ]);
        }
        return redirect()->route('rute')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id)
    {

        $menu = DataMenu::where('Menu_category', 'Master Menu')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $dtcustomer = DataCustomer::get();
        $rute = DataRute::where('rute_id', $id)->first();
        $selectedcustomer = DataDetailRute::where('rute_id', $id)->pluck('customer_kode')->toArray();

        return view('rute.edit', compact('menu', 'roleuser', 'rute', 'dtcustomer', 'selectedcustomer'));
    }

    public function update(Request $request, $id)
    {
        DataDetailRute::where('rute_id', $id)->delete();
        DataRute::where('rute_id', $id)->update([
            'rute_nama' => $request->nama
        ]);

        $customer_kode = $request->customer;

        foreach ($customer_kode as $kode) {
            DataDetailRute::create([
                'rute_id' => $id,
                'customer_kode' => $kode,
                'status'=> '',
            ]);
        }
        return redirect()->route('rute')->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $rute = DataRute::where('rute_id', $id);
        $detailrute = DataDetailRute::where('rute_id', $id);
        $rute->delete();
        $detailrute->delete();
        return redirect()->route('rute')->with('success', 'Data berhasil dihapus!');
    }

    public function import(Request $request)
    {
        Excel::import(new DataRuteImport, $request->file('file'));
        return redirect()->back()->with('success', 'Data berhasil diimpor!');
    }
}
