<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $guarded = [''];
    
    public function sousmenus()
    {
        return $this->hasMany(Sousmenu::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }
}
