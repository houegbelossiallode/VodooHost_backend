<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    protected $guarded = [];

    protected $casts = [
        'divinites_preferees' => 'array',        // IMPORTANT
        'assister_rituel' => 'boolean',
    ];
}
