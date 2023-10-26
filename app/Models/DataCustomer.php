<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataCustomer extends Model
{
    use HasFactory;
    protected $table = 'data_customer';
    protected $fillable = [
        'customer_id',
        'customer_kode',
        'kategori_customer_id',
        'customer_nama',
        'customer_nomor_hp',
        'customer_alamat',
        'latitude',
        'longtitude',
    ];

    public function kategori(){
        return $this->belongsTo(DataKategoriCustomer::class, 'kategori_customer_id', 'kategori_customer_id');
    }
}
