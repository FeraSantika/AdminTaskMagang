<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataDetailRute extends Model
{
    use HasFactory;
    protected $table = 'data_detail_rute';
    protected $primaryKey = 'detail_rute_id';
    protected $fillable = [
        'detail_rute_id',
        'rute_id',
        'customer_kode',
        'status'
    ];

    public function rute(){
        return $this->belongsTo(DataRute::class, 'rute_id', 'rute_id');
    }

    public function customer(){
        return $this->belongsTo(DataCustomer::class, 'customer_kode', 'customer_kode');
    }

    public function kunjungan(){
        return $this->belongsTo(DataKunjungan::class, 'rute_id', 'rute_id');
    }

    public function transaksi(){
        return $this->belongsTo(TransaksiDataProduk::class, 'customer_kode', 'customer_kode');
    }
}
