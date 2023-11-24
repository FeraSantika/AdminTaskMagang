<?php

namespace App\Http\Controllers;

use App\Models\DataMenu;
use App\Models\AksesDepo;
use App\Models\AksesDistributor;
use App\Models\DataCustomer;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Models\DataDetailRute;

class LaporanKunjunganDistributorController extends Controller
{
    public function index()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $user_id =  auth()->user()->User_id;
        $distributor_id = AksesDistributor::where('user_id', $user_id)->value('distributor_id');
        $customerDepo = DataCustomer::where('distributor_id', $distributor_id)->with('detailrute.kunjungan')->get();

        // dd($customerDepo);
        return view('laporan_kunjungan_distributor.index', compact('menu', 'roleuser','customerDepo', 'distributor_id'));
    }

    public function getData(Request $request)
    {
        $pilihStatus = $request->pilihStatus;
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');
        $depo = $request->input('depo');

        $dataTerfilter = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
            ->join('data_customer', 'data_detail_rute.customer_kode', 'data_customer.customer_kode')
            ->whereBetween('data_kunjungan.kunjungan_tanggal', [$tglAwal, $tglAkhir])
            ->where('data_detail_rute.status', $pilihStatus)
            ->where('data_customer.depo_id', $depo)
            ->groupBy('data_detail_rute.customer_kode')
            ->get();

        return response()->json($dataTerfilter);
    }
}