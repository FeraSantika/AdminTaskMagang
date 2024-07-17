<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AksesDepo extends Model
{
    use HasFactory;
    protected $table = 'akses_depo';
    protected $primaryKey = 'akses_depo_id';
    protected $fillable = [
        'akses_depo_id',
        'user_id',
        'depo_id',
    ];

    public function user()
    {
        return $this->belongsTo(DataUser::class, 'user_id', 'User_id');
    }

    public function depo()
    {
        return $this->belongsTo(DataDepo::class, 'depo_id', 'depo_id');
    }

    public function customer()
    {
        return $this->belongsTo(DataCustomer::class, 'depo_id', 'depo_id');
    }
}
