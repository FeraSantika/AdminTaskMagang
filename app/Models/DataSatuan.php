<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSatuan extends Model
{
    use HasFactory;
    protected $table = 'data_satuan';
    protected $primaryKey = 'satuan_id';
    protected $fillable = [
        'satuan_id',
        'satuan_nama'
    ];
}
