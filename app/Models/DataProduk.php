<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataProduk extends Model
{
    use HasFactory;
    protected $table = 'data_produk';
    protected $fillable = [
        'produk_id',
        'produk_kode',
        'produk_nama',
    ];
}
