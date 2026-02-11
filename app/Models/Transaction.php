<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Models\Compte;

class Transaction extends Model
{
    protected $guarded = [];

    protected $fillable = [
        'montant',
        'type',
        'compte_id',
        'reference',
        'description',
        'transactionable_id',
        'transactionable_type'
    ];

    protected $casts = [
        'montant' => 'decimal:2',
    ];

    /**
     * Obtenir le modèle parent (Retrait, etc.)
     */
    public function transactionable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Obtenir le compte associé à la transaction
     */
    public function compte()
    {
        return $this->belongsTo(Compte::class);
    }
}
