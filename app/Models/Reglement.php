<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reglement extends Model
{
    protected $fillable = [
        'logement_id',
        'libelle',
    ];

    public function logement()
    {
        return $this->belongsTo(Logement::class);
    }
}
