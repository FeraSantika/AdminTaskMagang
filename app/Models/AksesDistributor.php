<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AksesDistributor extends Model
{
    use HasFactory;
    protected $table = 'akses_distributor';
    protected $fillable = [
        'akses_distributor_id',
        'user_id',
        'distributor_id',
    ];

    public function user()
    {
        return $this->belongsTo(DataUser::class, 'user_id', 'User_id');
    }

    public function distributor()
    {
        return $this->belongsTo(DataDistributor::class, 'distributor_id', 'distributor_id');
    }

    public function depo()
    {
        return $this->belongsTo(DataDepo::class, 'distributor_id', 'distributor_id');
    }
}
