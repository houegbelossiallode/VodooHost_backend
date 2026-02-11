<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $guarded = [];

    public function logement(){
        return $this->belongsTo(Logement::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function revenuPlateforme(){
        return $this->hasOne(RevenuPlateforme::class);
    }

    public function projet()
    {
        
        return $this->belongsTo(Projet::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

}
