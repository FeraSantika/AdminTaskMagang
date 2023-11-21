<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\DataMenu;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Models\DataDetailRute;
use App\Models\ListDataProduk;
use Illuminate\Support\Facades\DB;
use App\Models\TransaksiDataProduk;
use App\Exports\laporanprodukExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\laporanpesananExport;

class CekPesananController extends Controller
{
    public function index()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $today = now()->format('Y-m-d');

        $dtkunjungan = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
            ->whereDate('data_kunjungan.kunjungan_tanggal', $today)
            ->with('rute', 'customer', 'transaksi.listproduk.produk')
            ->get();

        foreach ($dtkunjungan as $kunjungan) {
            $customer = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
                ->whereDate('data_kunjungan.kunjungan_tanggal', $today)
                ->where('data_detail_rute.rute_id', $kunjungan->rute_id)
                ->with('rute', 'customer', 'transaksi.listproduk.produk')
                ->pluck('customer_kode');
        }

        $dtpesan = ListDataProduk::join('data_detail_rute', 'list_data_produk.customer_kode', '=', 'data_detail_rute.customer_kode')
            ->join('transaksi_data_produk', 'list_data_produk.transaksi_kode', '=', 'transaksi_data_produk.transaksi_kode')
            ->select('list_data_produk.customer_kode', 'list_data_produk.produk_kode', 'list_data_produk.satuan_id', 'list_data_produk.transaksi_kode', DB::raw('SUM(list_data_produk.jumlah) as total_jumlah'))
            ->groupBy('list_data_produk.customer_kode', 'list_data_produk.produk_kode', 'list_data_produk.satuan_id')
            ->whereIn('list_data_produk.customer_kode', $customer)
            ->where('transaksi_data_produk.status', '=', 'Pesan')
            ->with('produk', 'satuan')
            ->get();

        // dd($dtpesan);
        return view('cek_pesanan.index', compact('menu', 'roleuser', 'dtkunjungan', 'dtpesan'));
    }

    public function exportPDF(Request $request)
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $today = now()->format('Y-m-d');

        $dtkunjungan = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
            ->whereDate('data_kunjungan.kunjungan_tanggal', $today)
            ->with('rute', 'customer', 'transaksi.listproduk.produk')
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

        $view = view('cek_pesanan.exportpdf', compact('dtkunjungan', 'dtpesan', 'menu', 'roleuser', 'printedDate'))->render();
        $pdf = new Dompdf();
        $pdf->loadHtml($view);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();

        $pdfContent = $pdf->output();
        $pdfFilePath = 'Laporan_Pesanan_' . $printedDate . '.pdf';
        \Illuminate\Support\Facades\Storage::put($pdfFilePath, $pdfContent);

        return $pdf->stream($pdfFilePath);
    }


    public function exportExcel(Request $request)
    {
        $today = now()->format('Y-m-d');

        $dtkunjungan = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
            ->whereDate('data_kunjungan.kunjungan_tanggal', $today)
            ->with('rute', 'customer', 'transaksi.listproduk.produk')
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


        $export = new laporanpesananExport($dtkunjungan, $dtpesan, $printedDate);
        $fileName = 'Laporan_Pesanan_' . now()->format('d-m-Y') . '.xlsx';

        return Excel::download($export, $fileName);
    }
}
