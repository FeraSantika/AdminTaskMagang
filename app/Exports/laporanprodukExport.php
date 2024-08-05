<?php

namespace App\Exports;

use App\Models\ListDataProduk;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class laporanprodukExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithMapping, WithDrawings

/**
 * @return \Illuminate\Support\Collection
 */
{
    public $tglAwal;
    public $tglAkhir;
    private $serialNumber;

    function __construct($tglAwal, $tglAkhir)
    {
        $this->tglAwal = $tglAwal . " 00:00:00";
        $this->tglAkhir = $tglAkhir . " 23:59:00";
        $this->serialNumber = 1;
    }

    public function collection()
    {
        $result  = ListDataProduk::select('produk_kode', 'satuan_id', DB::raw('SUM(jumlah) as total_jumlah'))
            ->whereBetween('created_at', [$this->tglAwal, $this->tglAkhir])
            ->groupBy('produk_kode')
            ->groupBy('satuan_id')
            ->with('produk', 'satuan')
            ->get();

        $formattedData = $result->map(function ($item) {
            return [
                'No' => $this->serialNumber++,
                'Kode Produk' => $item->produk_kode,
                'Nama Produk' => $item->produk->produk_nama,
                'Jumlah' => $item->total_jumlah,
                'Satuan' => $item->satuan->satuan_nama
            ];
        });

        return $formattedData;
    }

    public function headings(): array
    {
        $rs = ListDataProduk::first();
        $perusahaanName = 'PT Satya Amarta Prima';
        $perusahaanAddress = 'Jl. Villa Melati Mas Raya No.5 Blok B8-1, Jelupang, Serpong Utara, South Tangerang City, Banten 15323';

        $filterText = [
            [$perusahaanName],
            [$perusahaanAddress],
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
            'Satuan',
        ];
        return $filterText;
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = count($this->collection()) + 7;
        $sheet->mergeCells('A1:E1');
        $sheet->mergeCells('A2:E2');
        $sheet->mergeCells('A4:E4');
        $sheet->mergeCells('A6:E6');

        return [
            1 => [
                'font' => ['bold' => true, 'size' => 20],
            ],
            2 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center'],
            ],
            'A1:E1' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => true, 'size' => 20],
            ],
            'A2:E2' => [
                'font' => ['bold' => false],
            ],
            'A4:E4' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => true],
            ],
            'A5:E5' => [
                'font' => ['bold' => false],
            ],
            'A6:E6' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => false],
            ],
            'A7:E7' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => true],
                'borders' => ['allBorders' => ['borderStyle' => 'thick', 'color' => ['rgb' => '000000']]],
            ],

            'A8:E' . $lastRow => ['borders' => ['allBorders' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]]],
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
            'Satuan' => $data['Satuan'],
        ];
    }

    public function drawings()
    {
        $gambar = base_path('public\assets\images\logo.png');
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Presales');
        $drawing->setPath($gambar);
        $drawing->setHeight(25);
        $drawing->setCoordinates('A1');

        return [$drawing];
    }
}
