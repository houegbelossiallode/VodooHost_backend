<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Retrait extends Model
{
    protected $guarded = [];

    protected $casts = [
        'montant' => 'decimal:2',
    ];

    /**
     * Obtenir le compte associé au retrait
     */
    public function compte(): BelongsTo
    {
        return $this->belongsTo(Compte::class);
    }

    /**
     * Obtenir les transactions associées au retrait
     */
    public function transactions(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }

    /**
     * Obtenir l'utilisateur associé au retrait
     */
    public function user()
    {
        return $this->through('compte')->user();
    }
}
