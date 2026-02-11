<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sousmenu extends Model
{
     protected $guarded = [''];

    public function permissions()
    {
        return $this->hasMany(RolePermission::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
