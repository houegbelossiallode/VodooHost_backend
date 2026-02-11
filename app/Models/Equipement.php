<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipement extends Model
{
    protected $guarded = [];

    public function logements()
    {
        return $this->belongsToMany(\App\Models\Logement::class, 'equipement_logement', 'equipement_id', 'logement_id')
                    ->withTimestamps();
    }
}
