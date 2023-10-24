<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMenu extends Model
{
    use HasFactory;
    public $table = 'data_menu';
    protected $fillable = [
        'Menu_id',
        'Menu_name',
        'Menu_link',
        'Menu_category',
        'Menu_sub',
        'Menu_position',
    ];

    public function rolemenu(){
        return $this->hasMany(DataRoleMenu::class, 'Menu_id', 'Menu_id');
    }

    public function menu(){
        return $this->hasMany(DataMenu::class, 'Menu_sub', 'Menu_id');
    }
}

