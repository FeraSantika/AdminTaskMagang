<?php

namespace App\Exports;

use App\Models\DataMenu;
use App\Models\AksesDepo;
use App\Models\DataCustomer;
use App\Models\DataRoleMenu;
use App\Models\ListDataProduk;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class laporanprodukdepoExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithMapping

/**
 * @return \Illuminate\Support\Collection
 */
{
    public $tglAwal;
    public $tglAkhir;
    private $serialNumber;

    function __construct($tglAwal, $tglAkhir)
    {
        $this->tglAwal = $tglAwal;
        $this->tglAkhir = $tglAkhir;
        $this->serialNumber = 1;
    }

    public function collection()
    {
        $user_id =  auth()->user()->User_id;
        $depo_id = AksesDepo::where('user_id', $user_id)->value('depo_id');
        $customer = DataCustomer::where('depo_id', $depo_id)->pluck('customer_kode');
        $result  = ListDataProduk::whereIn('customer_kode', $customer)
            ->select('produk_kode', DB::raw('SUM(jumlah) as total_jumlah'))
            ->whereBetween('created_at', [$this->tglAwal, $this->tglAkhir])
            ->groupBy('produk_kode')
            ->with('produk')
            ->get();

        $formattedData = $result->map(function ($item) {
            return [
                'No' => $this->serialNumber++,
                'Kode Produk' => $item->produk_kode,
                'Nama Produk' => $item->produk->produk_nama,
                'Jumlah' => $item->total_jumlah,
            ];
        });

        return $formattedData;
    }

    public function headings(): array
    {
        $rs = ListDataProduk::first();
        $hospitalName = 'Anonim';
        $hospitalAddress = 'Anonim';

        $filterText = [
            [$hospitalName],
            [$hospitalAddress],
            [],
            ['Laporan Produk'],
            [],
        ];

        if ($this->tglAwal && $this->tglAkhir) {
            $filterText[] = ["Rentang Tanggal: {$this->tglAwal} hingga {$this->tglAkhir}"];
        } else {
            $filterText[] = ["Rentang Tanggal: Tanggal tidak diinputkan"];
        }

        $filterText[] = [
            'No',
            'Kode Produk',
            'Nama Produk',
            'Jumlah',
        ];
        return $filterText;
    }


    public function styles(Worksheet $sheet)
    {
        $lastRow = count($this->collection()) + 7;
        $sheet->mergeCells('A1:D1');
        $sheet->mergeCells('A2:D2');
        $sheet->mergeCells('A4:D4');
        $sheet->mergeCells('A6:D6');

        return [
            1 => [
                'font' => ['bold' => true, 'size' => 20],
            ],
            2 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center'],
            ],
            'A1:D1' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => true, 'size' => 20],
            ],
            'A2:D2' => [
                'font' => ['bold' => false],
            ],
            'A4:D4' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => true],
            ],
            'A5:D5' => [
                'font' => ['bold' => false],
            ],
            'A6:D6' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => false],
            ],
            'A7:D7' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => true],
                'borders' => ['allBorders' => ['borderStyle' => 'thick', 'color' => ['rgb' => '000000']]],
            ],

            'A8:D' . $lastRow => ['borders' => ['allBorders' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]]],
        ];
    }

    public function title(): string
    {
        return 'Laporan_Produk';
    }

    public function map($data): array
    {
        return [
            'No' => $data['No'],
            'Kode Produk' => $data['Kode Produk'],
            'Nama Produk' => $data['Nama Produk'],
            'Jumlah' => $data['Jumlah'],
        ];
    }
}
