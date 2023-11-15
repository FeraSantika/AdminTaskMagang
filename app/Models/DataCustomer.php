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
        'distributor_id',
        'depo_id',
        'customer_nama',
        'customer_nomor_hp',
        'customer_alamat',
        'latitude',
        'longtitude',
    ];

    public function kategori(){
        return $this->belongsTo(DataKategoriCustomer::class, 'kategori_customer_id', 'kategori_customer_id');
    }

    public function depo(){
        return $this->belongsTo(DataDepo::class, 'depo_id', 'depo_id');
    }

    public function distributor(){
        return $this->belongsTo(DataDistributor::class, 'distributor_id', 'distributor_id');
    }

    public function detailrute(){
        return $this->hasMany(DataDetailRute::class, 'customer_kode', 'customer_kode');
    }
}
