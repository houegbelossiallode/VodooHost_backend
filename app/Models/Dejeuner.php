<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dejeuner extends Model
{
    protected $guarded = [];

    public function logements()
    {
        return $this->belongsToMany(Logement::class, 'logement_dejeuner', 'dejeuner_id', 'logement_id');
    }
}
