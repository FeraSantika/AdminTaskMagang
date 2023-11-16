<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\DataMenu;
use App\Models\AksesDepo;
use App\Models\DataCustomer;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Models\ListDataProduk;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\laporanprodukdepoExport;

class LaporanProdukDepoController extends Controller
{
    public function index()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $user_id =  auth()->user()->User_id;
        $depo_id = AksesDepo::where('user_id', $user_id)->value('depo_id');
        $customer = DataCustomer::where('depo_id', $depo_id)->pluck('customer_kode');

        $produk = ListDataProduk::whereIn('customer_kode', $customer)->select('produk_kode', 'satuan_id', DB::raw('SUM(jumlah) as total_jumlah'))
            ->groupBy('produk_kode')
            ->groupBy('satuan_id')
            ->with('produk', 'satuan')
            ->get();

        // dd($produk);

        return view('laporan_produk_depo.index', compact('menu', 'roleuser', 'produk', 'customer'));
    }

    public function getData(Request $request)
    {
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');

        $user_id =  auth()->user()->User_id;
        $depo_id = AksesDepo::where('user_id', $user_id)->value('depo_id');
        $customer = DataCustomer::where('depo_id', $depo_id)->pluck('customer_kode');

        $dataTerfilter = ListDataProduk::whereIn('customer_kode', $customer)
            ->select('produk_kode', 'satuan_id', DB::raw('SUM(jumlah) as total_jumlah'))
            ->whereBetween('created_at', [$tglAwal, $tglAkhir])
            ->groupBy('produk_kode')
            ->groupBy('satuan_id')
            ->with('produk', 'satuan')
            ->get();

        return response()->json($dataTerfilter);
    }

    public function exportPDF(Request $request)
    {
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');

        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $user_id =  auth()->user()->User_id;
        $depo_id = AksesDepo::where('user_id', $user_id)->value('depo_id');
        $customer = DataCustomer::where('depo_id', $depo_id)->pluck('customer_kode');

        $dtproduk = ListDataProduk::whereIn('customer_kode', $customer)
            ->select('produk_kode', 'satuan_id', DB::raw('SUM(jumlah) as total_jumlah'))
            ->whereBetween('created_at', [$tglAwal, $tglAkhir])
            ->groupBy('produk_kode')
            ->groupBy('satuan_id')
            ->with('produk', 'satuan')
            ->get();

        $view = view('laporan_produk_depo.exportpdf', compact('dtproduk', 'tglAwal', 'tglAkhir', 'menu', 'roleuser'))->render();
        $pdf = new Dompdf();
        $pdf->loadHtml($view);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();

        $pdfContent = $pdf->output();

        $pdfFilePath = 'path_to_save.pdf';
        \Illuminate\Support\Facades\Storage::put($pdfFilePath, $pdfContent);

        return $pdf->stream('Laporan_Produk_Depo.pdf');
    }

    public function exportExcel(Request $request)
    {
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');

        return Excel::download(new laporanprodukdepoExport(
            $tglAwal,
            $tglAkhir,
        ), 'Laporan_Produk_Depo.xlsx');
    }
}
