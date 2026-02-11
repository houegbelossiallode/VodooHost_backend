<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use App\Models\Logement;
use App\Models\Notification;
use App\Models\Projet;
use App\Models\Reservation;
use App\Models\Retrait;
use App\Models\RevenuPlateforme;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $logements = Logement::where('actif', 'OUI')->count();
        $reservations = Reservation::count();
        $projets = Projet::where('actif', 'OUI')->count();
        $users = User::where('actif', 'OUI')->count();

        // Calculer les revenus totaux
        $totalRevenus = Reservation::sum('montant');

        // Récupérer les 12 derniers mois
        $moisLabels = [];
        $reservationsParMois = [];
        $revenusParMois = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $moisLabels[] = $date->translatedFormat('M Y');

            // Compter les réservations par mois
            $count = Reservation::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $reservationsParMois[] = $count;

            // Calculer les revenus par mois (en milliers pour une meilleure échelle)
            $revenus = Reservation::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('montant');
            $revenusParMois[] = $revenus; // Conversion en milliers


            //Commission + Part projet (2 courbes)
            $agg = RevenuPlateforme::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->selectRaw('COALESCE(SUM(commission),0) as commission,
                            COALESCE(SUM(part_projet),0) as part_projet')
                ->first();

            $commissionParMois[] = ((float) $agg->commission);
            $partProjetParMois[] = ((float) $agg->part_projet);
        }

        return view('dashboard', compact(
            'logements',
            'reservations',
            'projets',
            'users',
            'totalRevenus',
            'reservationsParMois',
            'revenusParMois',
            'moisLabels',
            'commissionParMois',
            'partProjetParMois'
        ));
    }


    public function stats(Request $request)
    {
        $period = $request->get('period', 'month');
        if (!in_array($period, ['week', 'month', 'year'])) {
            $period = 'month';
        }

        // --- Construire une liste de "périodes" ---
        // week  : 12 dernières semaines
        // month : 12 derniers mois
        // year  : 5 dernières années (tu peux changer)
        $items = collect();

        if ($period === 'week') {
            for ($i = 11; $i >= 0; $i--) {
                $start = now()->startOfWeek()->subWeeks($i);
                $end   = (clone $start)->endOfWeek();

                $items->push([
                    'key'   => $start->format('o-\WW'), // ex: 2025-W02 (clé stable)
                    'label' => 'S' . $start->format('W') . ' ' . $start->format('Y'),
                    'start' => $start,
                    'end'   => $end,
                ]);
            }
        }

        if ($period === 'month') {
            for ($i = 11; $i >= 0; $i--) {
                $start = now()->startOfMonth()->subMonths($i);
                $end   = (clone $start)->endOfMonth();

                $items->push([
                    'key'   => $start->format('Y-m'),
                    'label' => $start->translatedFormat('M Y'),
                    'start' => $start,
                    'end'   => $end,
                ]);
            }
        }

        if ($period === 'year') {
            for ($i = 4; $i >= 0; $i--) {
                $start = now()->startOfYear()->subYears($i);
                $end   = (clone $start)->endOfYear();

                $items->push([
                    'key'   => $start->format('Y'),
                    'label' => $start->format('Y'),
                    'start' => $start,
                    'end'   => $end,
                ]);
            }
        }

        // --- Initialiser les tableaux ---
        $labels = $items->pluck('label')->values()->all();

        $reservations = [];
        $revenus = [];
        $commission = [];
        $partProjet = [];

        foreach ($items as $it) {
            $start = $it['start'];
            $end   = $it['end'];

            $reservations[] = Reservation::whereBetween('created_at', [$start, $end])->count();

            $revenusBase = Reservation::whereBetween('created_at', [$start, $end])
                ->where('statut', 'PAYE')
                ->sum('montant');
            $revenus[] = round($revenusBase / 1000, 2); // k FCFA

            $commissionBase = RevenuPlateforme::whereBetween('created_at', [$start, $end])
                ->sum('commission_plateforme');
            $commission[] = round($commissionBase / 1000, 2); // k FCFA

            $partProjetBase = RevenuPlateforme::whereBetween('created_at', [$start, $end])
                ->sum('part_projet');
            $partProjet[] = round($partProjetBase / 1000, 2); // k FCFA
        }

        return response()->json([
            'period' => $period,
            'labels' => $labels,
            'series' => [
                'reservations' => $reservations,
                'revenus'      => $revenus,
                'commission'   => $commission,
                'part_projet'  => $partProjet,
            ],
        ]);
    }

    // public function admin()
    // {
    //     $revenuPlateforme = RevenuPlateforme::sum('commission');
    //     $contributionsTotal = RevenuPlateforme::sum('part_projet');
    //     $revenuHotes = Compte::sum('solde');
    //     $reservationsCount = Reservation::count();

    //     // Revenus mensuels
    //     $data = RevenuPlateforme::select(
    //                 DB::raw("DATE_PART('month', created_at) as month"),
    //                 DB::raw('SUM(commission + part_projet) as total')
    //                  )
    //             ->groupBy('month')
    //             ->orderBy('month')
    //             ->get();

    //     $months = [];
    //     $revenusMensuels = [];

    //     foreach ($data as $d) {
    //         $months[] = date('F', mktime(0,0,0,$d->month,1));
    //         $revenusMensuels[] = $d->total;
    //     }

    //     return view('welcome', compact(
    //         'revenuPlateforme',
    //         'contributionsTotal',
    //         'revenuHotes',
    //         'reservationsCount',
    //         'months',
    //         'revenusMensuels'
    //  ));
    //  }


    public function retrait(Request $request)
    {
        $statut = $request->input('statut');           // en_attente, valide, refuse
        $mode   = $request->input('mode');             // mobile_money, card
        $search = $request->input('q');                // recherche simple

        $query = Retrait::with(['compte.user'])
            ->orderBy('created_at', 'desc');

        if ($statut) {
            $query->where('statut', $statut);
        }

        if ($mode) {
            $query->where('methode', $mode);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('numero_compte', 'ILIKE', "%{$search}%")
                    ->orWhere('nom_titulaire', 'ILIKE', "%{$search}%")
                    ->orWhereHas('compte.user', function ($sub) use ($search) {
                        $sub->where('nom', 'ILIKE', "%{$search}%")
                            ->orWhere('prenom', 'ILIKE', "%{$search}%")
                            ->orWhere('email', 'ILIKE', "%{$search}%");
                    });
            });
        }

        $retraits = $query->paginate(20);

        return view('revenus.retraits.admin.index', compact('retraits', 'statut', 'mode', 'search'));
    }

    public function updateStatut(Request $request, Retrait $retrait)
    {
        $request->validate([
            'statut' => ['required', 'in:valide,refuse,en_attente'],
        ]);

        // On évite de retraiter un retrait déjà validé / refusé
        if ($retrait->statut === $request->statut) {
            return back()->with('info', 'Le retrait est déjà dans ce statut.');
        }

        try {
            $ancienStatut = $retrait->statut;
            $retrait->statut = $request->statut;
            $retrait->save();

            // Si tu veux rembourser le solde en cas de refus
            if ($ancienStatut === 'en_attente' && $request->statut === 'refuse') {
                $compte = $retrait->compte;
                // On recrédite le montant sur le compte (puisqu'on l'avait débité à la demande)
                $compte->increment('solde', $retrait->montant);
            }

            Notification::create([
                'user_id' => $retrait->compte->user->id,
                'type'    => 'retrait',
                'title'   => 'Retrait confirmé',
                'message' => "Votre demande de retrait de " . number_format($retrait->montant, 2) . " FCFA a été " . $request->statut . ".",
                // 'data'    => [
                //     'reservation_id' => $reservation->id,
                //     'logement_id'    => $logement->id,
                //     'date_debut'     => $reservation->date_debut,
                //     'date_fin'       => $reservation->date_fin,
                //     'montant'  => $reservation->montant_total,
                //     'devise'         => $reservation->devise,
                // ],
            ]);


            return back()->with('success', 'Le statut du retrait a été mis à jour.');
        } catch (Exception $e) {

            return back()->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }
}
