<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
     protected $guarded = [];
        
    public const STATUT_EN_ATTENTE = 'en_attente';
    public const STATUT_PAYE = 'paye';
    public const STATUT_ANNULE = 'annule';
    public const STATUT_ERREUR = 'erreur';

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    // public function marquerCommePayee(string $referencePaiement = null): void
    // {
    //     $this->update([
    //         'statut_paiement' => self::STATUT_PAYE,
    //         'reference_paiement' => $referencePaiement ?? $this->reference_paiement,
    //         'date_paiement' => now()
    //     ]);
    // }
}
