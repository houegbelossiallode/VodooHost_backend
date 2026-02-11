<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $guarded = [];
    public function logement()
    {
        return $this->belongsTo(Logement::class);
    }

    public function getUrlAttribute()
    {
        return $this->attributes['url'];
    }
}
