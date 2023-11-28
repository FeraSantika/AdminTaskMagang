<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\DataMenu;
use App\Models\AksesDepo;
use App\Models\DataCustomer;
use App\Models\DataRoleMenu;
use Illuminate\Http\Request;
use App\Models\DataDetailRute;
use App\Models\AksesDistributor;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\laporankunjungandistributorExport;

class LaporanKunjunganDistributorController extends Controller
{
    public function index()
    {
        $menu = DataMenu::where('Menu_category', 'Master Menu')->get();
        $user = auth()->user()->role;
        $roleuser = DataRoleMenu::where('Role_id', $user->Role_id)->get();

        $user_id =  auth()->user()->User_id;
        $distributor_id = AksesDistributor::where('user_id', $user_id)->value('distributor_id');
        $customerDistributor = DataDetailRute::join('data_customer', 'data_detail_rute.customer_kode', 'data_customer.customer_kode')
            ->join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
            ->where('data_customer.distributor_id', $distributor_id)
            ->paginate(10);

        // dd($customerDepo);
        return view('laporan_kunjungan_distributor.index', compact('menu', 'roleuser', 'customerDistributor', 'distributor_id'));
    }

    public function getData(Request $request)
    {
        $pilihStatus = $request->pilihStatus;
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');

        $user_id =  auth()->user()->User_id;
        $distributor_id = AksesDistributor::where('user_id', $user_id)->value('distributor_id');

        $dataTerfilter = DataDetailRute::join('data_customer', 'data_detail_rute.customer_kode', 'data_customer.customer_kode')
            ->join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
            ->where('data_customer.distributor_id', $distributor_id)
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

        $user_id =  auth()->user()->User_id;
        $distributor_id = AksesDistributor::where('user_id', $user_id)->value('distributor_id');

        $dtkunjungan = DataDetailRute::join('data_customer', 'data_detail_rute.customer_kode', 'data_customer.customer_kode')
            ->join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
            ->where('data_customer.distributor_id', $distributor_id)
            ->whereBetween('data_kunjungan.kunjungan_tanggal', [$tglAwal, $tglAkhir])
            ->where('data_detail_rute.status', $pilihStatus)
            ->get();

        $view = view('laporan_kunjungan_distributor.exportpdf', compact('dtkunjungan', 'tglAwal', 'tglAkhir', 'menu', 'roleuser', 'pilihStatus'))->render();
        $pdf = new Dompdf();
        $pdf->loadHtml($view);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();

        $pdfContent = $pdf->output();

        $pdfFilePath = 'path_to_save.pdf';
        \Illuminate\Support\Facades\Storage::put($pdfFilePath, $pdfContent);

        return $pdf->stream('Laporan_Kunjungan_Distributor.pdf');
    }

    public function exportExcel(Request $request)
    {
        $pilihStatus = $request->pilihStatus;
        $tglAwal = $request->input('tanggalAwal');
        $tglAkhir = $request->input('tanggalAkhir');

        return Excel::download(new laporankunjungandistributorExport(
            $tglAwal,
            $tglAkhir,
            $pilihStatus,
        ), 'Laporan_Kunjungan_Distributor.xlsx');
    }
}
