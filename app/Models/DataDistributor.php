<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataDistributor extends Model
{
    use HasFactory;
    public $table = 'data_distributor';
    protected $fillable = [
        'distributor_id',
        'distributor_nama'
    ];
}
