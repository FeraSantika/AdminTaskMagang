<?php

namespace App\Exports;

use App\Models\AksesDepo;
use App\Models\DataDetailRute;
use App\Models\AksesDistributor;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class laporankunjungandistributorExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithMapping
{
    public $tglAwal;
    public $tglAkhir;
    public $pilihStatus;
    private $serialNumber;

    function __construct($tglAwal, $tglAkhir, $pilihStatus)
    {
        $this->tglAwal = $tglAwal;
        $this->tglAkhir = $tglAkhir;
        $this->pilihStatus = $pilihStatus;
        $this->serialNumber = 1;
    }

    public function collection()
    {
        $user_id =  auth()->user()->User_id;
        $distributor_id = AksesDistributor::where('user_id', $user_id)->value('distributor_id');

        $result  = DataDetailRute::join('data_customer', 'data_detail_rute.customer_kode', 'data_customer.customer_kode')
        ->join('data_kunjungan', 'data_detail_rute.rute_id', 'data_kunjungan.rute_id')
        ->where('data_customer.distributor_id', $distributor_id)
        ->whereBetween('data_kunjungan.kunjungan_tanggal', [$this->tglAwal, $this->tglAkhir])
        ->where('data_detail_rute.status', $this->pilihStatus)
        ->get();

        $formattedData = $result->map(function ($item) {
            return [
                'No' => $this->serialNumber++,
                'Tanggal' => $item->kunjungan_tanggal,
                'Kode Customer' => $item->customer_kode,
                'Nama Customer' => $item->customer_nama,
                'Alamat Customer' => $item->customer_alamat,
                'Status' => $item->status,
            ];
        });

        return $formattedData;
    }

    public function headings(): array
    {
        $nama = 'Anonim';
        $alamat = 'Anonim';

        $filterText = [
            [$nama],
            [$alamat],
            [],
            ['Laporan Kunjungan Distributor'],
            [],
        ];

        if ($this->tglAwal && $this->tglAkhir && $this->pilihStatus) {
            $filterText[] = ["Rentang Tanggal: {$this->tglAwal} hingga {$this->tglAkhir}  || Status Kunjungan: {$this->pilihStatus} "];
        } else {
            $filterText[] = ["Rentang Tanggal: Tanggal tidak diinputkan || Status Kunjungan: Semua status kunjungan"];
        }

        $filterText[] = [
            'No',
            'Tanggal',
            'Kode Customer',
            'Nama Customer',
            'Alamat Customer',
            'Status',
        ];
        return $filterText;
    }


    public function styles(Worksheet $sheet)
    {
        $lastRow = count($this->collection()) + 7;
        $sheet->mergeCells('A1:F1');
        $sheet->mergeCells('A2:F2');
        $sheet->mergeCells('A4:F4');
        $sheet->mergeCells('A6:F6');

        return [
            1 => [
                'font' => ['bold' => true, 'size' => 20],
            ],
            2 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center'],
            ],
            'A1:F1' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => true, 'size' => 20],
            ],
            'A2:F2' => [
                'font' => ['bold' => false],
            ],
            'A4:F4' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => true],
            ],
            'A5:F5' => [
                'font' => ['bold' => false],
            ],
            'A6:F6' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => false],
            ],
            'A7:F7' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => true],
                'borders' => ['allBorders' => ['borderStyle' => 'thick', 'color' => ['rgb' => '000000']]],
            ],

            'A8:F' . $lastRow => ['borders' => ['allBorders' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]]],
        ];
    }

    public function title(): string
    {
        return 'Laporan_Kunjungan_Distributor';
    }

    public function map($data): array
    {
        return [
            'No' => $data['No'],
            'Tanggal' => $data['Tanggal'],
            'Kode Customer' => $data['Kode Customer'],
            'Nama Customer' => $data['Nama Customer'],
            'Alamat Customer' => $data['Alamat Customer'],
            'Status' => $data['Status'],
        ];
    }
}
