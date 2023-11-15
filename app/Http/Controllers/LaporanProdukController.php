<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\DataMenu;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Models\ListDataProduk;
use Illuminate\Support\Facades\DB;
use App\Exports\laporanprodukExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanProdukController extends Controller
{
    public function index()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $produk = ListDataProduk::select('produk_kode', DB::raw('SUM(jumlah) as total_jumlah'))
            ->groupBy('produk_kode')
            ->with('produk')
            ->get();

        return view('laporan_produk.index', compact('menu', 'roleuser', 'produk'));
    }

    public function getData(Request $request)
    {
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');

        $dataTerfilter = ListDataProduk::select('produk_kode', DB::raw('SUM(jumlah) as total_jumlah'))
            ->whereBetween('created_at', [$tglAwal, $tglAkhir])
            ->groupBy('produk_kode')
            ->with('produk')
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

        $dtproduk =  ListDataProduk::select('produk_kode', DB::raw('SUM(jumlah) as total_jumlah'))
            ->whereBetween('created_at', [$tglAwal, $tglAkhir])
            ->groupBy('produk_kode')
            ->with('produk')
            ->get();

        $view = view('laporan_produk.exportpdf', compact('dtproduk', 'tglAwal', 'tglAkhir', 'menu', 'roleuser'))->render();
        $pdf = new Dompdf();
        $pdf->loadHtml($view);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();

        $pdfContent = $pdf->output();

        $pdfFilePath = 'path_to_save.pdf';
        \Illuminate\Support\Facades\Storage::put($pdfFilePath, $pdfContent);

        return $pdf->stream('Laporan_Produk.pdf');
    }

    public function exportExcel(Request $request)
    {
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');

        return Excel::download(new laporanprodukExport(
            $tglAwal,
            $tglAkhir,
        ), 'Laporan_Produk.xlsx');
    }
}
