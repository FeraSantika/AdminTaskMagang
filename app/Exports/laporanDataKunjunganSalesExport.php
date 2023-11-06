<?php

namespace App\Exports;

use App\Models\DataPoli;
use App\Models\RumahSakit;
use App\Models\DataAntrian;
use App\Models\DataKunjungan;
use App\Models\DataUser;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class laporanDataKunjunganSalesExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithMapping
{
    public $tglAwal;
    public $tglAkhir;
    public $sales;
    private $serialNumber;

    function __construct($tglAwal, $tglAkhir, $pilihSales)
    {
        $this->tglAwal = $tglAwal;
        $this->tglAkhir = $tglAkhir;
        $this->sales = $pilihSales;
        $this->serialNumber = 1;
    }

    public function collection()
    {
        $result = DataKunjungan::with('user', 'rute')
            ->whereBetween('kunjungan_tanggal', [$this->tglAwal, $this->tglAkhir])
            ->where('User_id', $this->sales)
            ->get();

        $formattedData = $result->map(function ($item) {
            $tanggalFormatted = date('d-m-Y', strtotime($item->kunjungan_tanggal));
            return [
                'No' => $this->serialNumber++,
                'User' => $item->user->User_name,
                'Rute' => $item->rute->rute_nama,
                'Tanggal' => $tanggalFormatted,
            ];
        });

        return $formattedData;
    }

    public function headings(): array
    {
        $filterText = [
            ['Nama Perusahaan'],
            ['Alamat Perusahaan || Nomor Telepon || Kode Pos'],
            [],
            ['Laporan Data Kunjungan Sales'],
            [],
        ];

        if ($this->tglAwal && $this->tglAkhir) {
            $tglAwalFormatted = date('d-m-Y', strtotime($this->tglAwal));
            $tglAkhirFormatted = date('d-m-Y', strtotime($this->tglAkhir));
            $filterText[] = ["Rentang Tanggal: {$tglAwalFormatted} hingga {$tglAkhirFormatted}"];
        } else {
            $filterText[] = ["Rentang Tanggal: Tanggal tidak diinputkan"];
        }
        if ($this->sales) {
            $filterText[] = ["User: {$this->getNamaSales()}"];
        } else {
            $filterText[] = ["User: Semua Sales"];
        }

        $filterText[] = [
            'No',
            'User',
            'Rute',
            'Tanggal',
        ];
        return $filterText;
    }

    private function getNamaSales(): string
    {
        $idSales = $this->sales;

        $namaSales = DataUser::where('User_id', $idSales)->value('User_name');

        return $namaSales ?? '';
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = count($this->collection()) + 8;
        $sheet->mergeCells('A1:E1');
        $sheet->mergeCells('A2:E2');
        $sheet->mergeCells('A4:E4');
        $sheet->mergeCells('A6:E6');
        $sheet->mergeCells('A7:E7');

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
                'font' => ['bold' => false],
            ],
            'A7:D7' => [
                'font' => ['bold' => false],
            ],
            'A8:D8' => [
                'alignment' => ['horizontal' => 'center'],
                'font' => ['bold' => true],
            ],

            'A8:D' . $lastRow => ['borders' => ['allBorders' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]]],
        ];
    }

    public function title(): string
    {
        return 'Laporan_Data_Kunjungan_Sales';
    }

    public function map($data): array
    {
        return [
            'No' => $data['No'],
            'User' => $data['User'],
            'Rute' => $data['Rute'],
            'Tanggal' => $data['Tanggal'],
        ];
    }
}
