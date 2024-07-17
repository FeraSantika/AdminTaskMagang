<?php

namespace App\Models;

use App\Models\DataDetailRute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataKunjungan extends Model
{
    use HasFactory;
    protected $table = 'data_kunjungan';
    protected $primaryKey = 'kunjungan_id';
    protected $fillable = [
        'kunjungan_id',
        'user_id',
        'rute_id',
        'kunjungan_tanggal',
    ];

    public function user(){
        return $this->belongsTo(DataUser::class, 'user_id', 'User_id');
    }

    public function rute(){
        return $this->belongsTo(DataRute::class, 'rute_id', 'rute_id');
    }

    public function detailrute(){
        return $this->belongsTo(DataDetailRute::class, 'rute_id', 'rute_id');
    }
}
