<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use App\Models\Reservation;
use App\Models\Logement;
use Illuminate\Support\Facades\Auth;

class RevenueController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1) Le compte de l’hôte
        $compte = Compte::where('user_id', $user->id)->first();

        // 2) Ses logements
        $logements = Logement::where('user_id', $user->id)->get();

        // 3) Toutes ses réservations PAYÉES
        $reservations = Reservation::whereHas('logement', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->where('statut', 'PAYE')
            ->orderBy('created_at', 'desc')
            ->get();

        // 4) Total revenus générés ' revenue = montant reservation - (commission + part_projet)
        $revenusTotaux = $reservations->sum(function ($reservation) {
            return $reservation->montant - ($reservation->revenuPlateforme ? 
                $reservation->revenuPlateforme->commission + $reservation->revenuPlateforme->part_projet : 0);
        });

        return view('revenus.index', [
            'compte'         => $compte,
            'logements'      => $logements,
            'reservations'   => $reservations,
            'revenusTotaux'  => $revenusTotaux,
        ]);
    }
}
