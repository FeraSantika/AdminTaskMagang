<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiDataProduk extends Model
{
    use HasFactory;
    protected $table = 'transaksi_data_produk';
    protected $fillable = [
        'transaksi_id',
        'transaksi_kode',
        'customer_kode'
    ];

    public function listproduk(){
        return $this->hasMany(ListDataProduk::class, 'transaksi_kode', 'transaksi_kode');
    }
}
