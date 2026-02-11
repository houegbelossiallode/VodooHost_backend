<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quartier extends Model
{
    protected $guarded = [''];


    public function pointforts()
    {
        return $this->belongsToMany(Pointfort::class, 'pointfort_quartier','quartier_id', 'pointfort_id')->withTimestamps();
    }
}
