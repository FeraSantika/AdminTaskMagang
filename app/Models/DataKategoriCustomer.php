<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKategoriCustomer extends Model
{
    use HasFactory;
    protected $table = 'data_kategori_customer';
    protected $fillable = [
        'kategori_customer_id',
        'kategori_customer_nama',
    ];
}
