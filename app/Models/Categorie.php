<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $guarded = [];
    public function projets()
    {
        return $this->hasMany(Projet::class);
    }
}
