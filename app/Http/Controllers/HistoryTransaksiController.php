<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\DataMenu;
use App\Models\Notifikasi;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Models\DataDetailRute;
use App\Models\ListDataProduk;
use App\Models\AksesDistributor;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\laporanpesanandepoExport;
use App\Exports\laporanpesanandistributorExport;

class HistoryTransaksiController extends Controller
{
    public function index()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $today = now()->format('Y-m-d');
        $user_login = auth()->user()->User_id;
        $distributor_login = AksesDistributor::where('user_id', $user_login)->value('distributor_id');

        $kunjungan = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
            ->with('rute', 'customer', 'transaksi.listproduk.produk')
            ->get();

        if ($kunjungan) {
            $dtkunjungan = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
                ->with('rute', 'customer', 'transaksi.listproduk.produk')
                ->whereHas('customer', function ($query) use ($distributor_login) {
                    $query->where('distributor_id', $distributor_login);
                })
                ->get();
        } else {
            // dd("Tidak ada data kunjungan pada tanggal ini");
        }

        $customer = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
            ->with('rute', 'customer', 'transaksi.listproduk.produk')
            ->pluck('customer_kode');

        // $dtpesan = ListDataProduk::join('data_detail_rute', 'list_data_produk.customer_kode', '=', 'data_detail_rute.customer_kode')
        //     ->join('transaksi_data_produk', 'list_data_produk.transaksi_kode', '=', 'transaksi_data_produk.transaksi_kode')
        //     ->select('list_data_produk.customer_kode', 'list_data_produk.produk_kode', 'list_data_produk.satuan_id', 'list_data_produk.transaksi_kode', DB::raw('SUM(list_data_produk.jumlah) as total_jumlah'))
        //     ->groupBy('list_data_produk.customer_kode', 'list_data_produk.produk_kode', 'list_data_produk.satuan_id')
        //     ->whereIn('list_data_produk.customer_kode', $customer)
        //     ->where('transaksi_data_produk.status', '=', 'Selesai')
        //     ->with('produk', 'satuan')
        //     ->get();
        $dtpesan = ListDataProduk::join('data_detail_rute', 'list_data_produk.customer_kode', '=', 'data_detail_rute.customer_kode')
            ->join('transaksi_data_produk', 'list_data_produk.transaksi_kode', '=', 'transaksi_data_produk.transaksi_kode')
            ->select(
                'list_data_produk.customer_kode',
                'list_data_produk.produk_kode',
                'list_data_produk.satuan_id',
                'list_data_produk.transaksi_kode',
                DB::raw('SUM(list_data_produk.jumlah) as total_jumlah'),
                'transaksi_data_produk.created_at'
            )
            ->groupBy(
                'list_data_produk.customer_kode',
                'list_data_produk.produk_kode',
                'list_data_produk.satuan_id',
                'list_data_produk.transaksi_kode',
                'transaksi_data_produk.created_at'
            )
            ->whereIn('list_data_produk.customer_kode', $customer)
            ->where('transaksi_data_produk.status', '=', 'Selesai')
            ->with('produk', 'satuan', 'detailrute.customer')
            ->get();

            // dd($dtpesan);
        $distributor = auth()->user()->User_id;
        $distributor_id = AksesDistributor::where('user_id', $distributor)->first('distributor_id');
        if ($distributor_id) {
            $notif = Notifikasi::where('distributor_id', $distributor_id->distributor_id)
                ->sum('count');
        } else {
            $notif = 0;
        }

        return view('history_transaksi.index', compact('menu', 'roleuser', 'dtkunjungan', 'dtpesan', 'distributor_login', 'notif'));
    }

    public function exportPDF(Request $request)
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $today = now()->format('Y-m-d');
        $user_login = auth()->user()->User_id;
        $distributor_login = AksesDistributor::where('user_id', $user_login)->value('distributor_id');

        $dtkunjungan = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
            ->with('rute', 'customer', 'transaksi.listproduk.produk')
            ->whereHas('customer', function ($query) use ($distributor_login) {
                $query->where('distributor_id', $distributor_login);
            })
            ->get();

        $customer = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
            ->with('rute', 'customer', 'transaksi.listproduk.produk')
            ->pluck('customer_kode');

        $dtpesan = ListDataProduk::join('data_detail_rute', 'list_data_produk.customer_kode', '=', 'data_detail_rute.customer_kode')
            ->join('transaksi_data_produk', 'list_data_produk.transaksi_kode', '=', 'transaksi_data_produk.transaksi_kode')
            ->select(
                'list_data_produk.customer_kode',
                'list_data_produk.produk_kode',
                'list_data_produk.satuan_id',
                'list_data_produk.transaksi_kode',
                DB::raw('SUM(list_data_produk.jumlah) as total_jumlah'),
                'transaksi_data_produk.created_at'
            )
            ->groupBy(
                'list_data_produk.customer_kode',
                'list_data_produk.produk_kode',
                'list_data_produk.satuan_id',
                'list_data_produk.transaksi_kode',
                'transaksi_data_produk.created_at'
            )
            ->whereIn('list_data_produk.customer_kode', $customer)
            ->where('transaksi_data_produk.status', '=', 'Selesai')
            ->with('produk', 'satuan', 'detailrute.customer')
            ->get();

        $printedDate = now()->format('d-m-Y');

        $view = view('history_transaksi.exportpdf', compact('dtkunjungan', 'dtpesan', 'menu', 'roleuser', 'printedDate'))->render();
        $pdf = new Dompdf();
        $pdf->loadHtml($view);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();

        $pdfContent = $pdf->output();
        $pdfFilePath = 'Laporan_Pesanan_Distributor_' . $printedDate . '.pdf';
        \Illuminate\Support\Facades\Storage::put($pdfFilePath, $pdfContent);

        return $pdf->stream($pdfFilePath);
    }


    public function exportExcel(Request $request)
    {
        $today = now()->format('Y-m-d');
        $user_login = auth()->user()->User_id;
        $distributor_login = AksesDistributor::where('user_id', $user_login)->value('distributor_id');

        $dtkunjungan = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
            ->whereDate('data_kunjungan.kunjungan_tanggal', $today)
            ->with('rute', 'customer', 'transaksi.listproduk.produk')
            ->whereHas('customer', function ($query) use ($distributor_login) {
                $query->where('distributor_id', $distributor_login);
            })
            ->get();

        $customer = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
            ->whereDate('data_kunjungan.kunjungan_tanggal', $today)
            ->with('rute', 'customer', 'transaksi.listproduk.produk')
            ->pluck('customer_kode');

        $today = now()->format('Y-m-d');
        $dtpesan = ListDataProduk::join('data_detail_rute', 'list_data_produk.customer_kode', '=', 'data_detail_rute.customer_kode')
            ->join('transaksi_data_produk', 'list_data_produk.transaksi_kode', '=', 'transaksi_data_produk.transaksi_kode')
            ->select('list_data_produk.customer_kode', 'list_data_produk.produk_kode', 'list_data_produk.satuan_id', 'list_data_produk.transaksi_kode', DB::raw('SUM(list_data_produk.jumlah) as total_jumlah'))
            ->groupBy('list_data_produk.customer_kode', 'list_data_produk.produk_kode', 'list_data_produk.satuan_id')
            ->whereIn('list_data_produk.customer_kode', $customer)
            ->where('transaksi_data_produk.status', '=', 'Pesan')
            ->whereRaw('DATE(transaksi_data_produk.created_at) = ?', $today)
            ->with('produk', 'satuan')
            ->get();

        $printedDate = now()->format('d-m-Y');


        $export = new laporanpesanandistributorExport($dtkunjungan, $dtpesan, $printedDate);
        $fileName = 'Laporan_Pesanan_Distributor_' . now()->format('d-m-Y') . '.xlsx';

        return Excel::download($export, $fileName);
    }
}
