<?php

namespace App\Http\Controllers;

use App\Models\DataMenu;
use App\Models\AksesDepo;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Models\DataDetailRute;

class LaporanKunjunganDepoController extends Controller
{
    public function index()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $user_id =  auth()->user()->User_id;
        $customerDepo = AksesDepo::where('user_id', $user_id)->with('customer.detailrute')->get();

        $dtkunjungan = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')->with('rute', 'customer')->groupBy('data_detail_rute.customer_kode')->paginate(10);
        return view('laporan_kunjungan_depo.index', compact('menu', 'roleuser', 'dtkunjungan', 'customerDepo'));
    }

    public function getData(Request $request)
    {
        $pilihStatus = $request->pilihStatus;
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');

        $dataTerfilter = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')->with('rute', 'customer')
            ->whereBetween('data_kunjungan.kunjungan_tanggal', [$tglAwal, $tglAkhir])
            ->where('data_detail_rute.status', $pilihStatus)
            ->groupBy('data_detail_rute.customer_kode')
            ->get();

        return response()->json($dataTerfilter);
    }
}
