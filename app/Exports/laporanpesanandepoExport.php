<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Border;

class laporanpesanandepoExport implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    protected $dtkunjungan;
    protected $dtpesan;
    protected $printedDate;
    private $serialNumber;

    public function __construct($dtkunjungan, $dtpesan, $printedDate)
    {
        $this->dtkunjungan = $dtkunjungan;
        $this->dtpesan = $dtpesan;
        $this->printedDate = $printedDate;
        $this->serialNumber = 1;
    }

    public function collection()
    {
        $formattedData = collect([]);

        foreach ($this->dtkunjungan as $item) {
            $formattedData->push([
                'No' => $this->serialNumber++,
                'Kode Customer' => $item->customer_kode,
                'Nama Customer' => $item->customer->customer_nama,
                'Alamat Customer' => $item->customer->customer_alamat,
                'No.' => '',
                'Transaksi Kode' => '',
                'Kode Produk' => '',
                'Nama Produk' => '',
                'Jumlah' => '',
                'Satuan' => '',
            ]);

            foreach ($this->dtpesan->where('customer_kode', $item->customer_kode) as $pesan) {
                $formattedData->push([
                    'No.' => 'Pesanan : ',
                    'Transaksi Kode' => $pesan->transaksi_kode,
                    'Kode Produk' => $pesan->produk_kode,
                    'Nama Produk' => $pesan->produk->produk_nama,
                    'Jumlah' => $pesan->total_jumlah,
                    'Satuan' => $pesan->satuan->satuan_nama,
                ]);
            }
        }

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
            ['Laporan Pesanan Depo'],
            ["Tanggal: {$this->printedDate}"],
        ];

        $filterText[] = [
            'No.',
            'Kode Customer',
            'Nama Customer',
            'Alamat Customer',
        ];

        return $filterText;
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = count($this->collection()) + 6;

        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        $sheet->mergeCells('A1:F1');
        $sheet->mergeCells('A2:F2');
        $sheet->mergeCells('A4:F4');
        $sheet->mergeCells('A5:F5');

        $sheet->getStyle('A1:F1')->applyFromArray($styleArray);
        $sheet->getStyle('A2:F2')->applyFromArray($styleArray);
        $sheet->getStyle('A4:F4')->applyFromArray($styleArray);
        $sheet->getStyle('A5:F45')->applyFromArray($styleArray);
        $sheet->getStyle('A6:F6')->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]]
        ]);

        $sheet->getStyle('A7:F' . $lastRow)->applyFromArray([
            'font' => ['bold' => false],
            'alignment' => ['horizontal' => 'center'],
            'borders' => ['allBorders' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]]
        ]);

        return [
            1 => [
                'font' => ['bold' => true, 'size' => 20],
                'alignment' => ['horizontal' => 'center'],
            ],
            2 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center'],
            ],
            4 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center'],
            ],
            6 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }

    public function title(): string
    {
        return 'Laporan_Pesanan_Depo';
    }
}
