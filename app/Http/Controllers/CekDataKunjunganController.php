<?php

namespace App\Http\Controllers;

use App\Exports\laporanDataKunjunganSalesExport;
use Dompdf\Dompdf;
use App\Models\DataMenu;
use App\Models\DataUser;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Models\DataKunjungan;
use Maatwebsite\Excel\Facades\Excel;

class CekDataKunjunganController extends Controller
{
    public function index()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $dtkunjungan = DataKunjungan::with('user', 'rute')->paginate(10);
        $dtsales = DataUser::where('Role_id', 8)->get();
        return view('cek_kunjungan.index', compact('menu', 'roleuser', 'dtkunjungan', 'dtsales'));
    }

    public function getData(Request $request)
    {
        // $pilihSales = $request->input('pilihSales');
        $pilihSales = $request->pilihSales;
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');

        $dataTerfilter = DataKunjungan::with('user', 'rute')
            ->whereBetween('kunjungan_tanggal', [$tglAwal, $tglAkhir])
            ->where('User_id', $pilihSales)
            ->get();

        return response()->json($dataTerfilter);
    }

    public function exportPDF(Request $request)
    {
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');
        $pilihSales = $request->input('pilihSales');

        $kunjungan = DataKunjungan::with('user', 'rute')
            ->whereBetween('kunjungan_tanggal', [$tglAwal, $tglAkhir])
            ->where('User_id', $pilihSales)
            ->get();

        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $view = view('cek_kunjungan.exportpdf', compact('kunjungan', 'tglAwal', 'tglAkhir', 'menu', 'roleuser', 'pilihSales'))->render();
        $pdf = new Dompdf();
        $pdf->loadHtml($view);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();

        $pdfContent = $pdf->output();

        $pdfFilePath = 'path_to_save.pdf';
        \Illuminate\Support\Facades\Storage::put($pdfFilePath, $pdfContent);

        return $pdf->stream('Laporan_Data_Kunjungan_Sales.pdf');
    }

    public function exportExcel(Request $request)
    {
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');
        $pilihSales = $request->input('pilihSales');

        return Excel::download(new laporanDataKunjunganSalesExport(
            $tglAwal,
            $tglAkhir,
            $pilihSales,
        ), 'Laporan_Data_Kunjungan_Sales.xlsx');
    }
}
