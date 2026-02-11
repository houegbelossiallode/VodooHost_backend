<?php

namespace App\Services;

use App\Models\Logement;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DisponibiliteService
{
    /**
     * Vérifie si un logement est disponible pour une période donnée
     *
     * @param int $logementId
     * @param Carbon $dateArrivee
     * @param Carbon $dateDepart
     * @param int|null $excludeReservationId ID d'une réservation à exclure (pour les mises à jour)
     * @return bool
     */
    public function estDisponible(int $logementId, Carbon $dateArrivee, Carbon $dateDepart, ?int $excludeReservationId = null): bool
    {
        // Vérifier que les dates sont valides
        if ($dateArrivee->greaterThanOrEqualTo($dateDepart)) {
            return false;
        }

        // Vérifier que le logement existe et est actif
        $logement = Logement::find($logementId);
        if (!$logement || !$logement->est_actif) {
            return false;
        }

        // Vérifier les réservations existantes qui chevauchent la période demandée
        $query = Reservation::where('logement_id', $logementId)
            ->where('statut', '!=', Reservation::STATUT_ANNULEE) // Ne pas compter les réservations annulées
            ->where(function ($q) use ($dateArrivee, $dateDepart) {
                $q->whereBetween('date_arrivee', [$dateArrivee, $dateDepart->copy()->subDay()])
                  ->orWhereBetween('date_depart', [$dateArrivee->copy()->addDay(), $dateDepart])
                  ->orWhere(function ($q) use ($dateArrivee, $dateDepart) {
                      $q->where('date_arrivee', '<=', $dateArrivee)
                        ->where('date_depart', '>=', $dateDepart);
                  });
            });

        // Exclure une réservation spécifique (utile pour les mises à jour)
        if ($excludeReservationId) {
            $query->where('id', '!=', $excludeReservationId);
        }

        $reservationsExistant = $query->exists();

        // Vérifier les périodes d'indisponibilité du logement
        $indisponible = DB::table('logement_disponibilites')
            ->where('logement_id', $logementId)
            ->where('statut', 'indisponible')
            ->where(function ($q) use ($dateArrivee, $dateDepart) {
                $q->whereBetween('date_debut', [$dateArrivee, $dateDepart->copy()->subDay()])
                  ->orWhereBetween('date_fin', [$dateArrivee->copy()->addDay(), $dateDepart])
                  ->orWhere(function ($q) use ($dateArrivee, $dateDepart) {
                      $q->where('date_debut', '<=', $dateArrivee)
                        ->where('date_fin', '>=', $dateDepart);
                  });
            })
            ->exists();

        // Le logement est disponible s'il n'y a pas de réservations en conflit ni de période d'indisponibilité
        return !$reservationsExistant && !$indisponible;
    }

    /**
     * Vérifie la disponibilité de plusieurs logements pour une période donnée
     *
     * @param array $logementIds
     * @param Carbon $dateArrivee
     * @param Carbon $dateDepart
     * @return array [logement_id => bool]
     */
    public function verifierDisponibiliteMultiple(array $logementIds, Carbon $dateArrivee, Carbon $dateDepart): array
    {
        $resultats = [];
        
        foreach ($logementIds as $logementId) {
            $resultats[$logementId] = $this->estDisponible($logementId, $dateArrivee, $dateDepart);
        }
        
        return $resultats;
    }

    /**
     * Récupère les périodes d'indisponibilité d'un logement
     *
     * @param int $logementId
     * @param Carbon $debut
     * @param Carbon $fin
     * @return \Illuminate\Support\Collection
     */
    public function getIndisponibilites(int $logementId, Carbon $debut, Carbon $fin)
    {
        return DB::table('logement_disponibilites')
            ->where('logement_id', $logementId)
            ->where('statut', 'indisponible')
            ->where(function ($q) use ($debut, $fin) {
                $q->whereBetween('date_debut', [$debut, $fin])
                  ->orWhereBetween('date_fin', [$debut, $fin])
                  ->orWhere(function ($q) use ($debut, $fin) {
                      $q->where('date_debut', '<=', $debut)
                        ->where('date_fin', '>=', $fin);
                  });
            })
            ->orderBy('date_debut')
            ->get();
    }

    /**
     * Vérifie si une réservation est toujours valide (pas de conflit avec d'autres réservations)
     *
     * @param int $reservationId
     * @return bool
     */
    public function verifierValiditeReservation(int $reservationId): bool
    {
        $reservation = Reservation::findOrFail($reservationId);
        
        // Vérifier si la réservation est toujours valide
        return $this->estDisponible(
            $reservation->logement_id,
            $reservation->date_arrivee,
            $reservation->date_depart,
            $reservation->id
        );
    }

    /**
     * Récupère les dates disponibles pour un logement dans une plage donnée
     *
     * @param int $logementId
     * @param Carbon $debut
     * @param Carbon $fin
     * @return array
     */
    public function getDatesDisponibles(int $logementId, Carbon $debut, Carbon $fin): array
    {
        $datesDisponibles = [];
        $periode = new \DatePeriod(
            $debut->copy()->startOfDay(),
            new \DateInterval('P1D'),
            $fin->copy()->endOfDay()
        );

        // Récupérer les réservations existantes
        $reservations = Reservation::where('logement_id', $logementId)
            ->where('statut', '!=', Reservation::STATUT_ANNULEE)
            ->where(function ($q) use ($debut, $fin) {
                $q->whereBetween('date_arrivee', [$debut, $fin])
                  ->orWhereBetween('date_depart', [$debut, $fin])
                  ->orWhere(function ($q) use ($debut, $fin) {
                      $q->where('date_arrivee', '<=', $debut)
                        ->where('date_depart', '>=', $fin);
                  });
            })
            ->get();

        // Récupérer les périodes d'indisponibilité
        $indisponibilites = $this->getIndisponibilites($logementId, $debut, $fin);

        // Vérifier chaque jour de la période
        foreach ($periode as $date) {
            $estDisponible = true;
            $dateCourante = $date->format('Y-m-d');

            // Vérifier les réservations
            foreach ($reservations as $reservation) {
                if ($date->between(
                    $reservation->date_arrivee->startOfDay(),
                    $reservation->date_depart->copy()->subDay()->endOfDay()
                )) {
                    $estDisponible = false;
                    break;
                }
            }

            // Vérifier les périodes d'indisponibilité
            if ($estDisponible) {
                foreach ($indisponibilites as $indispo) {
                    $dateDebut = Carbon::parse($indispo->date_debut)->startOfDay();
                    $dateFin = Carbon::parse($indispo->date_fin)->endOfDay();
                    
                    if ($date->between($dateDebut, $dateFin)) {
                        $estDisponible = false;
                        break;
                    }
                }
            }

            if ($estDisponible) {
                $datesDisponibles[] = $dateCourante;
            }
        }

        return $datesDisponibles;
    }
}
