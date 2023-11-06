<?php

namespace App\Imports;

use App\Models\DataCustomer;
use App\Models\DataRute;
use App\Models\DataDetailRute;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class DataRuteImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            if ($index >= 1 && !empty($row[1])) {
                $rute_id = null;
                if (!empty($row[1])) {
                    $rute = DataRute::where('rute_id', $row[1])->first();

                    if ($rute) {
                        $rute_id = $rute->rute_id;
                    }
                }

                // dd ($rute_id);

                $customer_kode = null;
                if (!empty($row[2])) {
                    $customer = DataCustomer::where('customer_kode', $row[2])->first();

                    if ($customer) {
                        $customer_kode = $customer->customer_kode;
                    }
                }

                DataDetailRute::create([
                    'rute_id' => $rute_id,
                    'customer_kode' => $customer_kode,
                ]);
            }
        }
    }
}
