<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logement extends Model
{
    protected $guarded = [];
    

    public function reglements()
    {
        return $this->hasMany(\App\Models\Reglement::class);
    }

    public function dejeuners()
    {
        return $this->belongsToMany(Dejeuner::class, 'logement_dejeuner', 'logement_id', 'dejeuner_id')
                    ->withTimestamps();
    }

    public function avis()
    {
        return $this->hasMany(Avis::class);
    }
    public function pays()
    {
        return $this->belongsTo(Pays::class);
    }

    public function typelogement()
    {
        return $this->belongsTo(TypeLogement::class, 'type_logement_id');
    }

    public function quartier()
    {
        return $this->belongsTo(Quartier::class);
    }

    public function equipements()
    {
        return $this->belongsToMany(\App\Models\Equipement::class, 'equipement_logement', 'logement_id', 'equipement_id')
            ->withTimestamps();
    }

    public function divinites()
    {
        return $this->belongsToMany(\App\Models\Divinite::class, 'divinite_logement', 'logement_id', 'divinite_id')
            ->withTimestamps();
    }

    public function rituels()
    {
        return $this->belongsToMany(\App\Models\Rituel::class, 'rituel_logement', 'logement_id', 'rituel_id')
            ->withTimestamps();
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(
            Favorite::class,
            'favori_logements',
            'logement_id',
            'favorite_id'
        )->withTimestamps();
    }


    protected $casts = [
        'disponibilite' => 'boolean',
    ];


    public function disponibilites()
    {
        return $this->hasMany(LogementDisponibilite::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
