<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
     protected $guarded = [];
    // Constantes pour les statuts de paiement
    public const STATUT_EN_ATTENTE = 'en_attente';
    public const STATUT_PAYE = 'paye';
    public const STATUT_ECHEC = 'echec';
    public const STATUT_ANNULE = 'annule';
    public const STATUT_REMBOURSE = 'rembourse';
    public const STATUT_EN_TRAITEMENT = 'en_traitement';

    // Constantes pour les méthodes de paiement
    public const METHODE_CARTE = 'carte';
    public const METHODE_MTN = 'mtn_mobile_money';
    public const METHODE_MOOV = 'moov_money';
    public const METHODE_FEDAPAY = 'fedapay';
    public const METHODE_PAYPAL = 'paypal';
    public const METHODE_VIREMENT = 'virement';
    public const METHODE_ESPECES = 'especes';

    // Constantes pour les modes de paiement
    public const MODE_UNIQUE = 'paiement_unique';
    public const MODE_ACOMPTE = 'acompte';
    public const MODE_SOLDE = 'solde';

    

    /**
     * Utilisateur ayant effectué le paiement
     */
    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'utilisateur_id');
    // }

    
}
