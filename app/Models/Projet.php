<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    protected $guarded = [];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function revenusPlateforme()
    {
        // Projet -> Reservations -> RevenuPlateforme
        return $this->hasManyThrough(
            RevenuPlateforme::class, // modèle final
            Reservation::class,      // modèle intermédiaire
            'projet_id',             // clé étrangère sur reservations
            'reservation_id',        // clé étrangère sur revenu_plateformes
            'id',                    // clé locale sur projets
            'id'                     // clé locale sur reservations
        );
    }

    /**
     * Montant total collecté pour ce projet (somme des part_projet)
     */
    public function getMontantCollecteAttribute()
    {
        return $this->revenusPlateforme()->sum('part_projet');
    }

    /**
     * Progression du projet en % par rapport à l'objectif
     */
    public function getProgressionAttribute()
    {
        if (!$this->objectif || $this->objectif <= 0) {
            return 0;
        }

        $progress = ($this->montant_collecte / $this->objectif) * 100;

        // on limite à 100%
        return (int) min(100, round($progress));
    }





}
