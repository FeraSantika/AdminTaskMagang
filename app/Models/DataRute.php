<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataRute extends Model
{
    use HasFactory;
    protected $table = 'data_rute';
    protected $primaryKey = 'rute_id';
    protected $fillable = [
        'rute_id',
        'rute_nama',
    ];

    public function detail()
    {
        return $this->hasMany(DataDetailRute::class, 'rute_id');
    }
}
