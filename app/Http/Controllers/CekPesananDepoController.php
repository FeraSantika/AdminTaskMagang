<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\DataMenu;
use App\Models\AksesDepo;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Models\DataDetailRute;
use App\Models\ListDataProduk;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\laporanpesananExport;
use App\Exports\laporanpesanandepoExport;

class CekPesananDepoController extends Controller
{
    public function index()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $today = now()->format('Y-m-d');
        $user_login = auth()->user()->User_id;
        $depo_login = AksesDepo::where('user_id', $user_login)->value('depo_id');

        $kunjungan = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
            ->whereDate('data_kunjungan.kunjungan_tanggal', $today)
            ->with('rute', 'customer', 'transaksi.listproduk.produk')
            ->get();

        if ($kunjungan) {
            $dtkunjungan = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
                ->whereDate('data_kunjungan.kunjungan_tanggal', $today)
                ->with('rute', 'customer', 'transaksi.listproduk.produk')
                ->whereHas('customer', function ($query) use ($depo_login) {
                    $query->where('depo_id', $depo_login);
                })
                ->get();
            // dd($depo_login);
        } else {
            // dd("Tidak ada data kunjungan pada tanggal ini");
        }

        $customer = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
            ->whereDate('data_kunjungan.kunjungan_tanggal', $today)
            ->with('rute', 'customer', 'transaksi.listproduk.produk')
            ->pluck('customer_kode');


        $dtpesan = ListDataProduk::join('data_detail_rute', 'list_data_produk.customer_kode', '=', 'data_detail_rute.customer_kode')
            ->select('list_data_produk.customer_kode', 'list_data_produk.produk_kode', 'list_data_produk.satuan_id', 'list_data_produk.transaksi_kode', DB::raw('SUM(list_data_produk.jumlah) as total_jumlah'))
            ->groupBy('list_data_produk.customer_kode', 'list_data_produk.produk_kode', 'list_data_produk.satuan_id')
            ->whereIn('list_data_produk.customer_kode', $customer)
            ->where('data_detail_rute.status', '=', 'Pesan')
            ->with('produk', 'satuan')
            ->get();

        return view('cek_pesanan_depo.index', compact('menu', 'roleuser', 'dtkunjungan', 'dtpesan', 'depo_login'));
    }

    public function exportPDF(Request $request)
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $today = now()->format('Y-m-d');
        $user_login = auth()->user()->User_id;
        $depo_login = AksesDepo::where('user_id', $user_login)->value('depo_id');

        $dtkunjungan = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
            ->whereDate('data_kunjungan.kunjungan_tanggal', $today)
            ->with('rute', 'customer', 'transaksi.listproduk.produk')
            ->whereHas('customer', function ($query) use ($depo_login) {
                $query->where('depo_id', $depo_login);
            })
            ->get();

        $customer = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
            ->whereDate('data_kunjungan.kunjungan_tanggal', $today)
            ->with('rute', 'customer', 'transaksi.listproduk.produk')
            ->pluck('customer_kode');

        $dtpesan = ListDataProduk::join('data_detail_rute', 'list_data_produk.customer_kode', '=', 'data_detail_rute.customer_kode')
            ->select('list_data_produk.customer_kode', 'list_data_produk.produk_kode', 'list_data_produk.satuan_id', 'list_data_produk.transaksi_kode', DB::raw('SUM(list_data_produk.jumlah) as total_jumlah'))
            ->groupBy('list_data_produk.customer_kode', 'list_data_produk.produk_kode', 'list_data_produk.satuan_id')
            ->whereIn('list_data_produk.customer_kode', $customer)
            ->where('data_detail_rute.status', '=', 'Pesan')
            ->with('produk', 'satuan')
            ->get();

        $printedDate = now()->format('d-m-Y');

        $view = view('cek_pesanan_depo.exportpdf', compact('dtkunjungan', 'dtpesan', 'menu', 'roleuser', 'printedDate'))->render();
        $pdf = new Dompdf();
        $pdf->loadHtml($view);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();

        $pdfContent = $pdf->output();
        $pdfFilePath = 'Laporan_Pesanan_Depo_' . $printedDate . '.pdf';
        \Illuminate\Support\Facades\Storage::put($pdfFilePath, $pdfContent);

        return $pdf->stream($pdfFilePath);
    }


    public function exportExcel(Request $request)
    {
        $today = now()->format('Y-m-d');
        $user_login = auth()->user()->User_id;
        $depo_login = AksesDepo::where('user_id', $user_login)->value('depo_id');

        $dtkunjungan = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
            ->whereDate('data_kunjungan.kunjungan_tanggal', $today)
            ->with('rute', 'customer', 'transaksi.listproduk.produk')
            ->whereHas('customer', function ($query) use ($depo_login) {
                $query->where('depo_id', $depo_login);
            })
            ->get();

        $customer = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
            ->whereDate('data_kunjungan.kunjungan_tanggal', $today)
            ->with('rute', 'customer', 'transaksi.listproduk.produk')
            ->pluck('customer_kode');

        $dtpesan = ListDataProduk::join('data_detail_rute', 'list_data_produk.customer_kode', '=', 'data_detail_rute.customer_kode')
            ->select('list_data_produk.customer_kode', 'list_data_produk.produk_kode', 'list_data_produk.satuan_id', 'list_data_produk.transaksi_kode', DB::raw('SUM(list_data_produk.jumlah) as total_jumlah'))
            ->groupBy('list_data_produk.customer_kode', 'list_data_produk.produk_kode', 'list_data_produk.satuan_id')
            ->whereIn('list_data_produk.customer_kode', $customer)
            ->where('data_detail_rute.status', '=', 'Pesan')
            ->with('produk', 'satuan')
            ->get();

        $printedDate = now()->format('d-m-Y');


        $export = new laporanpesanandepoExport($dtkunjungan, $dtpesan, $printedDate);
        $fileName = 'Laporan_Pesanan_Depo_' . now()->format('d-m-Y') . '.xlsx';

        return Excel::download($export, $fileName);
    }
}
