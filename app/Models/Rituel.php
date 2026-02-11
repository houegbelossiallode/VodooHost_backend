<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rituel extends Model
{
    protected $guarded = [];

    public function logements()
    {
        return $this->belongsToMany(\App\Models\Logement::class, 'rituel_logement', 'rituel_id', 'logement_id')
                    ->withTimestamps();
    }
}
