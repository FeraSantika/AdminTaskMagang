<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataRoleMenu extends Model
{
    use HasFactory;
    public $table = 'data_role_menu';
    protected $fillable = [
        'Role_menu_id',
        'Role_id',
        'Menu_id',
    ];

    public function role(){
        return $this->belongsTo(DataRole::class, 'Role_id', 'Role_id');
    }

    public function menu(){
        return $this->belongsTo(DataMenu::class, 'Menu_id', 'Menu_id');
    }

}
