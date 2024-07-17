<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListDataProduk extends Model
{
    use HasFactory;
    protected $table = 'list_data_produk';
    protected $primaryKey = 'list_id';
    protected $fillable = [
        'list_id',
        'produk_kode',
        'transaksi_kode',
        'customer_kode',
        'jumlah',
        'satuan_id',
    ];

    public function produk()
    {
        return $this->belongsTo(DataProduk::class, 'produk_kode', 'produk_kode');
    }

    public function satuan()
    {
        return $this->belongsTo(DataSatuan::class, 'satuan_id', 'satuan_id');
    }

    public function detailrute()
    {
        return $this->hasMany(DataDetailRute::class, 'customer_kode', 'customer_kode');
    }
}
