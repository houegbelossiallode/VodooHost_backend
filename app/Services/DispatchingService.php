<?php

namespace App\Services;

use App\Models\{
    Compte,
    Transaction,
    RevenuPlateforme,
    Reservation,
    Logement
};

class DispatchingService
{
    public function dispatchPaiement(array $payload, Reservation $reservation)
    {
        /** PARTS */
        $montantTotal        = $payload['montant_total'];
        $commissionPlateforme = $payload['commission'];
        $montantContribution  = $payload['montant_contribution'];
        $partHote             = $montantTotal - $commissionPlateforme - $montantContribution;

        /*****************************************
         * 1) COMPTE HÔTE
         *****************************************/
        $logement = Logement::find($payload['logement_id']);
        $hote     = $logement->user;

        $compteHote = Compte::firstOrCreate(
            ['user_id' => $hote->id],
            ['solde' => 0]
        );

        // créditer l’hôte uniquement
        $compteHote->increment('solde', $partHote);


        /*****************************************
         * 2) REVENU PLATEFORME (commission + projet)
         *****************************************/
        RevenuPlateforme::create([
            'reservation_id' => $reservation->id,
            'commission'     => $commissionPlateforme,
            'part_projet' => $montantContribution
        ]);


        /*****************************************
         * 3) TRANSACTION GLOBALE (visiteur -> plateforme)
         *****************************************/
        Transaction::create([
            'compte_id' => $compteHote->id,
            'montant'  => $montantTotal,
            'type'           => 'credit',
            //'moyen'          => $payload['mode_paiement'],
            //'statut'         => 'valide'
        ]);
    }
}                       