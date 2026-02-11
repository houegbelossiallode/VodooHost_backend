<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    protected $guarded = [];

    public function logement(){
        return $this->belongsTo(Logement::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
