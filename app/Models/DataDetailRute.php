<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataDetailRute extends Model
{
    use HasFactory;
    protected $table = 'data_detail_rute';
    protected $fillable = [
        'detail_rute_id',
        'rute_id',
        'customer_kode',
    ];

    public function rute(){
        return $this->belongsTo(DataRute::class, 'rute_id', 'rute_id');
    }

    public function customer(){
        return $this->belongsTo(DataCustomer::class, 'customer_kode', 'customer_kode');
    }
}
