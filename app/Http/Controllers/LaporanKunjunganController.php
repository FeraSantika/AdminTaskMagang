<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\DataMenu;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Models\DataDetailRute;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\laporankunjunganExport;

class LaporanKunjunganController extends Controller
{
    public function index()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $dtkunjungan = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')->with('rute', 'customer')->paginate(10);
        return view('laporan_kunjungan.index', compact('menu', 'roleuser', 'dtkunjungan'));
    }

    public function getData(Request $request)
    {
        $pilihStatus = $request->pilihStatus;
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');

        $dataTerfilter = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')->with('rute', 'customer')
            ->whereBetween('data_kunjungan.kunjungan_tanggal', [$tglAwal, $tglAkhir])
            ->where('data_detail_rute.status', $pilihStatus)
            ->get();

        return response()->json($dataTerfilter);
    }

    public function exportPDF(Request $request)
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $pilihStatus = $request->pilihStatus;
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');

        $dtkunjungan = DataDetailRute::join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')->with('rute', 'customer')
            ->whereBetween('data_kunjungan.kunjungan_tanggal', [$tglAwal, $tglAkhir])
            ->where('data_detail_rute.status', $pilihStatus)
            ->get();

        $view = view('laporan_kunjungan.exportpdf', compact('dtkunjungan', 'tglAwal', 'tglAkhir', 'menu', 'roleuser', 'pilihStatus'))->render();
        $pdf = new Dompdf();
        $pdf->loadHtml($view);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();

        $pdfContent = $pdf->output();

        $pdfFilePath = 'path_to_save.pdf';
        \Illuminate\Support\Facades\Storage::put($pdfFilePath, $pdfContent);

        return $pdf->stream('Laporan_Kunjungan.pdf');
    }

    public function exportExcel(Request $request)
    {
        $pilihStatus = $request->pilihStatus;
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');

        return Excel::download(new laporankunjunganExport(
            $tglAwal,
            $tglAkhir,
            $pilihStatus,
        ), 'Laporan_Kunjungan.xlsx');
    }
}
