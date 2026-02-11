<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Divinite extends Model
{
    protected $guarded = [];

    public function logements()
    {
        return $this->belongsToMany(\App\Models\Logement::class, 'divinite_logement', 'divinite_id', 'logement_id')
                    ->withTimestamps();
    }
}
