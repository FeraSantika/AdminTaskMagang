<?php

namespace App\Http\Controllers;

use App\Models\DataMenu;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Models\DataDetailRute;
use App\Models\ListDataProduk;
use Illuminate\Support\Facades\DB;
use App\Models\TransaksiDataProduk;

class CekPesananController extends Controller
{
    public function index()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $today = now()->format('Y-m-d');
        $sales = auth()->user()->User_id;
        $dtkunjungan = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
            ->whereDate('data_kunjungan.kunjungan_tanggal', $today)
            ->with('rute', 'customer', 'transaksi.listproduk.produk')
            ->get();

        $customer = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
            ->whereDate('data_kunjungan.kunjungan_tanggal', $today)
            ->with('rute', 'customer', 'transaksi.listproduk.produk')
            ->pluck('customer_kode');


        $dtpesan = ListDataProduk::join('data_detail_rute', 'list_data_produk.customer_kode', '=', 'data_detail_rute.customer_kode')
            ->select('list_data_produk.customer_kode', 'list_data_produk.produk_kode', 'list_data_produk.satuan_id', DB::raw('SUM(list_data_produk.jumlah) as total_jumlah'))
            ->groupBy('list_data_produk.customer_kode', 'list_data_produk.produk_kode', 'list_data_produk.satuan_id')
            ->whereIn('list_data_produk.customer_kode', $customer)
            ->where('data_detail_rute.status', '=', 'Pesan')
            ->with('produk', 'satuan')
            ->get();

        // dd($dtpesan);

        return view('cek_pesanan.index', compact('menu', 'roleuser', 'dtkunjungan', 'dtpesan'));
    }
}
