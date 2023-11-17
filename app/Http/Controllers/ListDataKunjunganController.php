<?php

namespace App\Http\Controllers;

use App\Models\DataMenu;
use App\Models\DataProduk;
use App\Models\DataSatuan;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Models\DataDetailRute;
use App\Models\ListDataProduk;
use App\Models\TransaksiDataProduk;

class ListDataKunjunganController extends Controller
{
    public function index()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $today = now()->format('Y-m-d');
        $sales = auth()->user()->User_id;
        $dtkunjungan = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')->where('data_kunjungan.user_id', $sales)->whereDate('data_kunjungan.kunjungan_tanggal', $today)->with('rute', 'customer')->get();
        // dd($sales);
        return view('list_kunjungan.index', compact('menu', 'roleuser', 'dtkunjungan'));
    }

    public function detail($customer_kode)
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $today = now()->format('Y-m-d');
        $sales = auth()->user()->User_id;
        $dtkunjungan = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
            ->where('data_detail_rute.customer_kode', $customer_kode)
            ->where('data_kunjungan.kunjungan_tanggal', $today)
            ->with('customer')->first();
        $dtproduk = DataProduk::get();
        $dtlistproduk = ListDataProduk::where('customer_kode', $customer_kode)->where('transaksi_kode', null)->with('produk', 'satuan')->get();
        $dtsatuan = DataSatuan::get();
        $transaksi = TransaksiDataProduk::where('customer_kode', $customer_kode)->whereDate('created_at', $today)->first();

        if ($transaksi) {
            $dtpesan = TransaksiDataProduk::join('data_detail_rute', 'transaksi_data_produk.customer_kode', 'data_detail_rute.customer_kode')
                ->where('transaksi_data_produk.customer_kode', $customer_kode)
                ->where('transaksi_data_produk.transaksi_kode', $transaksi->transaksi_kode)
                ->where('data_detail_rute.status', '=', 'Pesan')
                ->with('listproduk.produk')
                ->groupBy('transaksi_data_produk.transaksi_kode')
                ->get();
            $dttransaksi = TransaksiDataProduk::join('data_detail_rute', 'transaksi_data_produk.customer_kode', 'data_detail_rute.customer_kode')
                ->where('transaksi_data_produk.customer_kode', $customer_kode)
                ->where('transaksi_data_produk.transaksi_kode', $transaksi->transaksi_kode)
                ->where('data_detail_rute.status', '=', 'Selesai')
                ->with('listproduk.produk')
                ->groupBy('transaksi_data_produk.transaksi_kode')
                ->get();
        } else {
            $dtpesan = TransaksiDataProduk::join('data_detail_rute', 'transaksi_data_produk.customer_kode', 'data_detail_rute.customer_kode')
                ->where('transaksi_data_produk.customer_kode', $customer_kode)
                ->where('data_detail_rute.status', '=', 'Pesan')
                ->with('listproduk.produk')
                ->get();
            $dttransaksi = TransaksiDataProduk::join('data_detail_rute', 'transaksi_data_produk.customer_kode', 'data_detail_rute.customer_kode')
                ->where('transaksi_data_produk.customer_kode', $customer_kode)
                ->where('data_detail_rute.status', '=', 'Selesai')
                ->with('listproduk.produk')
                ->groupBy('transaksi_data_produk.transaksi_kode')
                ->get();
        }
        // dd($today);

        $prefix = 'T-PRD';
        $length = 4;
        $lastTransaksi = TransaksiDataProduk::orderBy('transaksi_id', 'desc')->first();
        if ($lastTransaksi) {
            $lastId = (int) substr($lastTransaksi->transaksi_kode, strlen($prefix));
        } else {
            $lastId = 0;
        }
        $nextId = $lastId + 1;
        $paddedId = str_pad($nextId, $length, '0', STR_PAD_LEFT);
        $transaksiCode = $prefix . $paddedId;

        return view('list_kunjungan.detail', compact('menu', 'roleuser', 'dtkunjungan', 'dtproduk', 'dtlistproduk', 'dtsatuan', 'transaksiCode', 'dttransaksi', 'dtpesan', 'transaksi', 'today'));
    }

    public function autocomplete(Request $request)
    {
        $data = DataProduk::select("produk_nama as label", "produk_kode as value")
            ->where('produk_nama', 'LIKE', '%' . $request->get('cari') . '%')
            ->get();

        return response()->json($data);
    }

    public function insertlist(Request $request)
    {
        $produk = DataProduk::where('produk_kode', $request->kode)->first();
        $satuan = DataSatuan::where('satuan_id', $request->satuan)->first();
        $listProduk = ListDataProduk::create([
            'produk_kode' => $produk->produk_kode,
            'customer_kode' => $request->customer,
            'jumlah' => $request->jumlah,
            'satuan_id' => $request->satuan,
        ]);

        $data = [
            'produk_nama' => $produk->produk_nama,
            'produk_kode' => $produk->produk_kode,
            'jumlah' => $listProduk->jumlah,
            'satuan' => $satuan->satuan_nama
        ];

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data' => $data
        ]);
    }

    public function destroy($list_id)
    {
        $list = ListDataProduk::where('list_id', $list_id);
        $list->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
            'data' => $list,
        ]);
    }

    public function storelist(Request $request)
    {
        $data = TransaksiDataProduk::create([
            'transaksi_kode' => $request->transaksi_kode,
            'customer_kode' => $request->customer_kode,
        ]);

        ListDataProduk::where('customer_kode', $request->customer_kode)->where('transaksi_kode', null)->update([
            'transaksi_kode' => $request->transaksi_kode,
        ]);

        DataDetailRute::where('detail_rute_id', $request->detail_rute_id)->update([
            'status' => $request->action
        ]);

        return redirect()->back()->with('success', 'Data Berhasil Disimpan!');
    }

    public function updatelist(Request $request)
    {
        DataDetailRute::where('detail_rute_id', $request->detail_rute_id)->update([
            'status' => $request->status
        ]);

        // DataDetailRute::join('transaksi_data_produk', 'data_detail_rute.customer_kode', 'transaksi_data_produk.customer_kode')
        // ->where('data_detail_rute.customer_kode', $request->customer_kode)
        // ->where('transaksi_data_produk.transaksi_kode', $request->transaksi_kode)->update([
        //     'data_detail_rute.status' => $request->action
        // ]);

        return redirect()->back()->with('success', 'Data Berhasil Disimpan!');
    }
}
