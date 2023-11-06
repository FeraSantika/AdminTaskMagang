<?php

namespace App\Imports;

use App\Models\DataKunjungan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class DataKunjunganImport implements ToCollection
{
    /**
     * @param Collection $collection
     */

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            if ($index >= 1) {
                $tanggalFormatted = $this->parseDate($row[3]);
                $user_id = null;
                if (!empty($row[1])) {
                    $user = DataKunjungan::whereHas('user', function ($query) use ($row) {
                        $query->where('User_name', $row[1]);
                    })->first();

                    if ($user) {
                        $user_id = $user->user_id;
                    }
                }
                $rute_id = null;
                if (!empty($row[2])) {
                    $rute = DataKunjungan::whereHas('rute', function ($query) use ($row) {
                        $query->where('rute_nama', $row[2]);
                    })->first();

                    if ($rute) {
                        $rute_id = $rute->rute_id;
                    }
                }

                DataKunjungan::create([
                    'user_id' => $user_id,
                    'rute_id' => $rute_id,
                    'kunjungan_tanggal' => $tanggalFormatted,
                ]);

                $formattedData = [
                    'User' => $user_id,
                    'Rute' => $row[2],
                    'Tanggal' => $tanggalFormatted,
                ];
            }
        }
    }

    private function parseDate($date)
    {
        $dateTime = \DateTime::createFromFormat('d-m-Y', $date);
        if ($dateTime !== false) {
            $date = $dateTime->format('Y-m-d');
        }
        return $date;
    }
}
