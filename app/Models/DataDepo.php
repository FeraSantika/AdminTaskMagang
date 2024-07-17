<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataDepo extends Model
{
    use HasFactory;
    protected $table = 'data_depo';
    protected $primaryKey = 'depo_id';
    protected $fillable = [
        'depo_id',
        'distributor_id',
        'depo_nama'
    ];

    public function distributor(){
        return $this->belongsTo(DataDistributor::class, 'distributor_id', 'distributor_id');
    }
}
