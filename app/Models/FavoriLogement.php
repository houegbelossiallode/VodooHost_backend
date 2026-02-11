<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriLogement extends Model
{
   protected $table = 'favori_logements';
    protected $guarded = [];

    public function favorite() {
        return $this->belongsTo(Favorite::class, 'favorite_id');
    }

    public function logement() {
        return $this->belongsTo(Logement::class);
    }
}
