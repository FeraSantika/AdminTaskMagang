<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataRole extends Model
{
    use HasFactory;
    public $table = 'data_role';
    protected $fillable = [
        'Role_id',
        'Role_name',
    ];

    public function rolemenu()
    {
        return $this->hasMany(DataRoleMenu::class, 'Role_id', 'Role_id')->with('menu');
    }


    public function user()
    {
        return $this->hasMany(DataUser::class, 'Role_id', 'Role_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
