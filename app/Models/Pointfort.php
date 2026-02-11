<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pointfort extends Model
{
    protected $guarded = [];

    public function quartiers()
    {
        return $this->belongsToMany(Quartier::class, 'pointfort_quartier','pointfort_id','quartier_id')->withTimestamps();
    }
}
