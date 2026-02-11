<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Favorite extends Model
{
    protected $table = 'favorites';
    protected $guarded = [];
   protected $casts = [
        'est_partage' => 'boolean',
    ];

    protected static function booted() {
        static::creating(function($m){
            if (empty($m->lien_partage)) {
                // lien public non devinable
                $m->lien_partage = (string) Str::uuid();
            }
            if ($m->actif === null) {
                $m->actif = 'OUI';
            }
        });
    }

    public function items() {
        return $this->hasMany(FavoriLogement::class, 'favorite_id');
    }

    public function logements()
    {
        return $this->belongsToMany(
            \App\Models\Logement::class,   // related
            'favori_logements',           // pivot table
            'favorite_id',                 // foreign key de CE modèle dans la pivot
            'logement_id'                  // foreign key du modèle lié dans la pivot
        )->withTimestamps();
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
