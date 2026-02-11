<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogementDisponibilite extends Model
{

    
    protected $table = 'logement_disponibilites';

    protected $fillable = [
        'logement_id',
        'date_debut',
        'date_fin',
        'statut',
    ];

    public function logement()
    {
        return $this->belongsTo(Logement::class);
    }
}
