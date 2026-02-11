<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    protected $guarded = [''];

    public function sousmenu()
    {
        return $this->belongsTo(Sousmenu::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    protected $casts = [
    'is_granted' => 'boolean'
    ];
}
