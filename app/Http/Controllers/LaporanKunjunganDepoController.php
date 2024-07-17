<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\DataMenu;
use App\Models\AksesDepo;
use App\Models\DataCustomer;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Models\DataDetailRute;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\laporankunjungandepoExport;

class LaporanKunjunganDepoController extends Controller
{
    public function index()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $user_id =  auth()->user()->User_id;
        $depo_id = AksesDepo::where('user_id', $user_id)->value('depo_id');
        $customerDepo = DataDetailRute::join('data_customer', 'data_detail_rute.customer_kode', 'data_customer.customer_kode')
            ->join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
            ->where('data_customer.depo_id', $depo_id)->paginate(10);
        return view('laporan_kunjungan_depo.index', compact('menu', 'roleuser', 'customerDepo', 'depo_id'));
    }

    public function getData(Request $request)
    {
        $pilihStatus = $request->pilihStatus;
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');

        $user_id =  auth()->user()->User_id;
        $depo_id = AksesDepo::where('user_id', $user_id)->value('depo_id');
        $dataTerfilter =  DataDetailRute::join('data_customer', 'data_detail_rute.customer_kode', 'data_customer.customer_kode')
            ->join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
            ->where('data_customer.depo_id', $depo_id)
            ->where('data_detail_rute.status', $pilihStatus)
            ->whereBetween('data_kunjungan.kunjungan_tanggal', [$tglAwal, $tglAkhir])
            ->get();

        return response()->json($dataTerfilter);
    }

    public function exportPDF(Request $request)
    {
        $pilihStatus = $request->pilihStatus;
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');

        $menu = DataMenu::where('Menu_category', 'Master Menu')->with('menu')->orderBy('Menu_position', 'ASC')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $user_id =  auth()->user()->User_id;
        $depo_id = AksesDepo::where('user_id', $user_id)->value('depo_id');

        $dtkunjungan = DataDetailRute::join('data_customer', 'data_detail_rute.customer_kode', 'data_customer.customer_kode')
            ->join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
            ->where('data_customer.depo_id', $depo_id)
            ->where('data_detail_rute.status', $pilihStatus)
            ->whereBetween('data_kunjungan.kunjungan_tanggal', [$tglAwal, $tglAkhir])
            ->get();

        $view = view('laporan_kunjungan_depo.exportpdf', compact('dtkunjungan', 'tglAwal', 'tglAkhir', 'menu', 'roleuser', 'pilihStatus'))->render();
        $pdf = new Dompdf();
        $pdf->loadHtml($view);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();

        $pdfContent = $pdf->output();

        $pdfFilePath = 'path_to_save.pdf';
        \Illuminate\Support\Facades\Storage::put($pdfFilePath, $pdfContent);

        return $pdf->stream('Laporan_Kunjungan_Depo.pdf');
    }

    public function exportExcel(Request $request)
    {
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');
        $pilihStatus = $request->pilihStatus;

        return Excel::download(new laporankunjungandepoExport(
            $tglAwal,
            $tglAkhir,
            $pilihStatus,
        ), 'Laporan_Kunjungan_Depo.xlsx');
    }
}
