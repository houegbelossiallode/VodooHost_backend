<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use FedaPay\FedaPay;
use App\Models\Projet;
use App\Models\Logement;
use App\Models\Paiement;
use FedaPay\Transaction;
use App\Models\Constance;
use App\Models\Reservation;
use App\Models\Contribution;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\RevenuPlateforme;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Mail\ReservationSuccessMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Models\LogementDisponibilite;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;


class ReservationController extends Controller
{
    // Afficher le formulaire de réservation
    public function create(Logement $logement, Request $request)
    {
        // Vérifier si l'utilisateur est connecté
        // if (!auth()->check()) {
        //     return redirect()->route('hoost.login.form')->with('error', 'Veuillez vous connecter pour effectuer une réservation.');
        // }

        // Récupérer les paramètres de la requête
        $debut = $request->query('date_debut');
        $fin = $request->query('date_fin');
        $nbVoyageurs = $request->query('nb_voyageur', 1);

        // Valider les dates
        if ($debut && $fin) {
            $validator = Validator::make([
                'date_debut' => $debut,
                'date_fin' => $fin,
            ], [
                'date_debut' => 'required|date|after_or_equal:today',
                'date_fin' => 'required|date|after:date_debut',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Vérifier la disponibilité
            // if (!$logement->estDisponible($debut, $fin)) {
            //     return redirect()->back()
            //         ->with('error', 'Ce logement n\'est pas disponible pour les dates sélectionnées.')
            //         ->withInput();
            // }
        }

        // Récupérer les projets communautaires
        $projet = Projet::latest()->get();

        // Calculer le prix total si les dates sont fournies
        $prixTotal = null;
        $nbNuits = null;
        $contribution = null;

        if ($debut && $fin) {
            $nbNuits = Carbon::parse($debut)->diffInDays(Carbon::parse($fin));
            $prixTotal = $nbNuits * $logement->prix_par_nuit;
            $contribution = $prixTotal * 0.05; // 5% de contribution
        }

        return view('reservations.create', compact(
            'logement',
            'projet',
            'debut',
            'fin',
            'nbVoyageurs',
            'prixTotal',
            'nbNuits',
            'contribution',
            'debut',
            'fin'
        ));
    }

    // Traiter la réservation
    // public function store(Request $request, Logement $logement)
    // {
    //     // Valider les données du formulaire
    //     $validated = $request->validate([
    //         'date_debut' => 'required|date|after_or_equal:today',
    //         'date_fin' => 'required|date|after:date_debut',
    //         'voyageurs' => 'required|integer|min:1|max:' . $logement->nb_voyageur_max,
    //         'projet_id' => 'required|exists:projets,id',
    //         'mode_paiement' => 'required|in:unique,acompte',
    //         'conditions' => 'accepted',
    //     ], [
    //         'conditions.accepted' => 'Vous devez accepter les conditions générales pour continuer.',
    //         'voyageurs.max' => 'Le nombre de voyageurs ne peut pas dépasser la capacité maximale du logement.',
    //     ]);

    //     // Vérifier la disponibilité
    //     if (!$logement->estDisponible($validated['date_debut'], $validated['date_fin'])) {
    //         return back()
    //             ->with('error', 'Ce logement n\'est plus disponible pour les dates sélectionnées.')
    //             ->withInput();
    //     }

    //     // Calculer le montant total
    //     $nuits = Carbon::parse($validated['date_debut'])->diffInDays(Carbon::parse($validated['date_fin']));
    //     $montantTotal = $nuits * $logement->prix_par_nuit;
    //     $contribution = $montantTotal * 0.05; // 5% de contribution

    //     // Calculer le montant à payer selon le mode de paiement
    //     $montantAPayer = $validated['mode_paiement'] === 'acompte' ?
    //         $montantTotal * 0.3 : // Acompte de 30%
    //         $montantTotal; // Paiement en une fois

    //     // Démarrer une transaction de base de données
    //     DB::beginTransaction();

    //     try {
    //         // Créer la réservation
    //         $reservation = Reservation::create([
    //             'logement_id' => $logement->id,
    //             'user_id' => Auth::id(),
    //             'date_debut' => $validated['date_debut'],
    //             'date_fin' => $validated['date_fin'],
    //             'nombre_voyageurs' => $validated['voyageurs'],
    //             'montant_total' => $montantTotal,
    //             'statut' => Reservation::STATUT_EN_ATTENTE_PAIEMENT,
    //             'mode_paiement' => $validated['mode_paiement'],
    //         ]);

    //         // Créer la contribution au projet
    //         $contribution = Contribution::create([
    //             'reservation_id' => $reservation->id,
    //             'projet_id' => $validated['projet_id'],
    //             'montant_contribution' => $contribution,
    //             'date_contribution' => now(),
    //             'statut' => 'en_attente',
    //         ]);

    //         // Valider la transaction
    //         DB::commit();

    //         // Envoyer une notification à l'utilisateur
    //         $user = Auth::user();
    //         $user->notify(new ReservationCreated($reservation));

    //         // Rediriger vers la page de paiement
    //         return redirect()->route('hoost.paiements.create', $reservation)
    //             ->with('success', 'Réservation enregistrée. Veuillez procéder au paiement.');

    //     } catch (\Exception $e) {
    //         // En cas d'erreur, annuler la transaction
    //         DB::rollBack();
    //         \Log::error('Erreur lors de la création de la réservation: ' . $e->getMessage());

    //         return back()
    //             ->with('error', 'Une erreur est survenue lors de la création de votre réservation. Veuillez réessayer.')
    //             ->withInput();
    //     }
    // }

    // Afficher le récapitulatif de la réservation
    public function show(Reservation $reservation)
    {


        return view('reservations.show', compact('reservation'));
    }



    // public function checkout(Request $request, Logement $logement)
    // {
    //     $request->validate([
    //         'date_debut' => 'required|date|after_or_equal:today',
    //         'date_fin'   => 'required|date|after:date_debut',
    //         'nb_voyageur' => 'required|integer|min:1|max:' . $logement->nb_voyageur_max,
    //         'projet_id'  => 'nullable|exists:projets,id',
    //     ]);

    //     $dateDebut = new Carbon($request->date_debut);
    //     $dateFin   = new Carbon($request->date_fin);
    //     $nuits     = $dateDebut->diffInDays($dateFin);

    //     $basePrix = $nuits * $logement->prix_par_nuit;

    //     $projet = $request->filled('projet_id')
    //         ? Projet::find($request->projet_id)
    //         : null;

    //     $pct     = $projet?->pourcentage_contribution ?? 0;
    //     $contrib = $basePrix * $pct / 100;
    //     $total   = $basePrix + $contrib;

    //     return view('reservations.checkout', [
    //         'logement' => $logement,
    //         'dateDebut' => $dateDebut,
    //         'dateFin' => $dateFin,
    //         'nuits' => $nuits,
    //         'nbVoyageur' => $request->nb_voyageur,
    //         'projet' => $projet,
    //         'basePrix' => $basePrix,
    //         'contrib' => $contrib,
    //         'total' => $total,
    //     ]);
    // }


    public function checkout(Request $request, Logement $logement)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Veuillez vous connecter pour réserver ce logement');
        }
        // 1. Vérification des paramètres requis
        $request->validate([
            'date_debut'   => 'required|date',
            'date_fin'     => 'required|date|after:date_debut',
            'nb_voyageur'  => 'required|integer|min:1',
            'projet_id'    => 'nullable|exists:projets,id',
        ]);

        $dateDebut = Carbon::parse($request->date_debut);
        $dateFin   = Carbon::parse($request->date_fin);

        // Vérification blocage dates
        $isBlocked = LogementDisponibilite::where('logement_id', $logement->id)
            ->where('statut', '!=', 'disponible')
            ->where(function ($q) use ($dateDebut, $dateFin) {
                $q->whereBetween('date_debut', [$dateDebut, $dateFin])
                    ->orWhereBetween('date_fin', [$dateDebut, $dateFin])
                    ->orWhere(function ($q2) use ($dateDebut, $dateFin) {
                        $q2->where('date_debut', '<', $dateDebut)
                            ->where('date_fin', '>', $dateFin);
                    });
            })
            ->exists();

        if ($isBlocked) {
            return back()->with('error', "Les dates choisies ne sont pas disponibles.");
        }

        // 2. Calcul du prix
        $nuits     = $dateDebut->diffInDays($dateFin);
        $prixNuit  = $logement->prix_par_nuit;
        $basePrix  = $prixNuit * $nuits;

        // 3. Projet communautaire
        $projet = Projet::find($request->projet_id);

        $contrib = $projet
            ? round($basePrix * ($projet->pourcentage_contribution / 100))
            : 0;

        //$total = $basePrix + $contrib;
        $total = $basePrix;
        // 4. Affichage vue checkout
        return view('reservations.checkout', [
            'logement'      => $logement,
            'dateDebut'     => $dateDebut,
            'dateFin'       => $dateFin,
            'nbVoyageur'    => $request->nb_voyageur,
            'projet'        => $projet,
            'nuits'         => $nuits,
            'basePrix'      => $basePrix,
            'contrib'       => $contrib,
            'total'         => $total,
        ]);
    }


    public function store(Request $request, Logement $logement)
    {
        //try {
            // 1) Validation de base
            $data = $request->validate([
                'date_debut'          => ['required', 'date', 'after_or_equal:today'],
                'date_fin'            => ['required', 'date', 'after:date_debut'],
                'nb_voyageur'         => ['required', 'integer', 'min:1'],
                'projet_id'           => ['nullable', 'integer'],
                'mode_paiement'       => ['nullable'],
                'gateway'             => ['required', 'in:fedapay,kkiapay,paypal'],
               ],[
                'date_debut.required'  => 'La date d’arrivée est obligatoire.',
                'date_fin.required'    => 'La date de départ est obligatoire.',
                'date_fin.after'       => 'La date de départ doit être postérieure à la date d’arrivée.',
                'nb_voyageur.required' => 'Le nombre de voyageurs est obligatoire.',
                'nb_voyageur.min'      => 'Le nombre de voyageurs doit être au moins 1.',
            ]);

            $user = Auth::user();

            // 2) Vérifier que le nombre de voyageurs ne dépasse pas la capacité
            if ($data['nb_voyageur'] > $logement->nb_voyageur_max) {
                return back()
                    ->withInput()
                    ->with('error', "Ce logement ne peut pas accueillir plus de {$logement->nb_voyageur_max} voyageurs.");
            }

            $dateDebut = Carbon::parse($data['date_debut'])->startOfDay();
            $dateFin   = Carbon::parse($data['date_fin'])->startOfDay();

            // 3) Vérifier les disponibilités : aucune période non disponible / réservée ne doit chevaucher
            $conflit = LogementDisponibilite::query()
                ->where('logement_id', $logement->id)
                ->whereIn('statut', ['indisponible', 'reserver'])
                ->where(function ($q) use ($dateDebut, $dateFin) {
                    $q->whereBetween('date_debut', [$dateDebut, $dateFin->copy()->subDay()])
                        ->orWhereBetween('date_fin', [$dateDebut->copy()->addDay(), $dateFin])
                        ->orWhere(function ($q2) use ($dateDebut, $dateFin) {
                            $q2->where('date_debut', '<=', $dateDebut)
                                ->where('date_fin', '>=', $dateFin);
                        });
                })
                ->exists();

            if ($conflit) {
                return back()
                    ->withInput()
                    ->with('error', "Les dates choisies chevauchent une période déjà réservée ou indisponible.");
            }

            // 4) Calcul du nombre de nuits
            $nbNuits = $dateDebut->diffInDays($dateFin);
            if ($nbNuits <= 0) {
                $nbNuits = 1;
            }

            $prixParNuit  = (int) $logement->prix_par_nuit;
            $montantNuitee = $nbNuits * $prixParNuit;

            // 5) Projet communautaire
            $projet = null;
            $pourcentageContribution = 0;
            if (!empty($data['projet_id'])) {
                $projet = Projet::find($data['projet_id']);
                if ($projet) {
                    $pourcentageContribution = $projet->pourcentage_contribution;
                }
            }

            //Récupérer le pourcentage depuis la table constantes
            $pourcentage = Constance::where('param','pourcentage')->first();
            $part_plateforme = $pourcentage->val;
            //dd($part_plateforme);
            $montantContribution = $montantNuitee * ($pourcentageContribution / 100);
            $commission   =   $montantNuitee * ($part_plateforme / 100);
            //$montantTotal        = $montantNuitee + $montantContribution;
            $montantTotal = $montantNuitee;
            // 6) Préparer un "token" sécurisé avec toutes les infos pour le callback
            $payload = [
                'user_id'               => $user->id,
                'logement_id'           => $logement->id,
                'date_debut'            => $dateDebut->toDateString(),
                'date_fin'              => $dateFin->toDateString(),
                'nb_nuits'              => $nbNuits,
                'nb_voyageur'           => $data['nb_voyageur'],
                'projet_id'             => $projet?->id,
                'pourcentage_contribution' => $pourcentageContribution,
                'montant_nuitee'        => $montantNuitee,
                'montant_contribution'  => $montantContribution,
                'montant_total'         => $montantTotal,
                'devise'                => $data['devise'] ?? 'XOF',
                'mode_paiement'         => $data['gateway'],
                'commission'            => $commission,
            ];

            $secureToken = Crypt::encryptString(json_encode($payload));

            // 7) Selon la passerelle choisie : FedaPay ou Kkiapay
            if ($data['gateway'] === 'fedapay') {
                // ==== FLOW FedaPay (ton code actuel) ====
                FedaPay::setApiKey(config('services.fedapay.secret'));
                FedaPay::setEnvironment(config('services.fedapay.env', 'sandbox'));

                $transaction = Transaction::create([
                    'description'  => "Réservation logement #{$logement->id} - {$logement->titre}",
                    'amount'       => $montantTotal, // entier
                    'currency'     => ['iso' => $payload['devise']], // ex: XOF
                    'callback_url' => route('hoost.reservations.fedapay.callback', [
                        'token' => $secureToken,
                    ]),
                    'customer'     => [
                        'firstname'    => $user->prenom ?? '',
                        'lastname'     => $user->nom ?? '',
                        'email'        => $user->email,
                        'phone_number' => [
                            'number'  => $user->telephone ?? '',
                            'country' => 'BJ',
                        ],
                    ],
                ]);

                $token = $transaction->generateToken();
                return redirect($token->url);
            } elseif ($data['gateway'] === 'kkiapay') {
                // ==== FLOW Kkiapay ====
                // On envoie l'utilisateur sur une vue avec le widget Kkiapay
                return view('paiements.kkiapay', [
                    'amount'       => $montantTotal,
                    'payloadToken' => $secureToken,
                    'user'         => $user,
                    'logement'     => $logement,
                ]);
            } elseif ($data['gateway'] === 'paypal') {

                $paypalOrderId = app(\App\Services\PayPalService::class)
                    ->createOrder(
                        $montantTotal,
                        'USD', // PayPal recommande USD
                        route('hoost.paypal.callback', ['token' => $secureToken]),
                        route('hoost.paypal.cancel', ['logement' => $logement->id])
                    );

                return redirect($paypalOrderId); // lien approval PayPal
            }

        // } catch (Exception $e) {
        //     return redirect()->back()->with('error', "Erreur lors de la vérification du paiement : " . $e->getMessage());
        // }
    }


    public function fedapayCallback(Request $request)
    {
        // 1) Récupérer l'ID de la transaction FedaPay et le token
        $transactionId = $request->query('id');
        $statusFromUrl = $request->query('status'); // informatif
        $token         = $request->query('token');

        if (!$transactionId || !$token) {
            return redirect()
                ->route('hoost.home') // ou une autre route
                ->with('error', "Informations de paiement incomplètes.");
        }

        // 2) Récupérer le payload depuis le token
        try {
            $payload = json_decode(Crypt::decryptString($token), true);
        } catch (Exception $e) {
            return redirect()
                ->route('hoost.home')
                ->with('error', "Le lien de paiement est invalide ou expiré.");
        }

        // 3) Config FedaPay
        FedaPay::setApiKey(config('services.fedapay.secret'));
        FedaPay::setEnvironment(config('services.fedapay.env', 'live'));

        try {
            // 4) Vérifier la vraie transaction FedaPay
            $transaction = Transaction::retrieve($transactionId);
            $status      = $transaction->status ?? null;

            if ($status !== 'approved') {
                return redirect()
                    ->route('hoost.logements.show', $payload['logement_id'])
                    ->with('error', "Le paiement n'a pas été approuvé (statut : {$status}).");
            }

            // 5) Re-vérifier la disponibilité AVANT de créer la réservation
            $dateDebut = Carbon::parse($payload['date_debut'])->startOfDay();
            $dateFin   = Carbon::parse($payload['date_fin'])->startOfDay();
            $conflit = LogementDisponibilite::query()
                ->where('logement_id', $payload['logement_id'])
                ->whereIn('statut', ['indisponible', 'reserver']) // à aligner avec la BDD
                ->where(function ($q) use ($dateDebut, $dateFin) {
                    $q->where('date_debut', '<=', $dateFin)
                        ->where('date_fin', '>=', $dateDebut);
                })
                ->exists();


            if ($conflit) {
                return redirect()
                    ->route('hoost.logements.show', $payload['logement_id'])
                    ->with('error', "Malheureusement, les dates ne sont plus disponibles.");
            }

            // 6) Créer la réservation SEULEMENT MAINTENANT
            $reservation = Reservation::create([
                'user_id'              => $payload['user_id'],
                'logement_id'          => $payload['logement_id'],
                'date_debut'           => $payload['date_debut'],
                'date_fin'             => $payload['date_fin'],
                'nb_nuits'             => $payload['nb_nuits'],
                'nb_voyageurs'          => $payload['nb_voyageur'],
                'projet_id'            => $payload['projet_id'],
                'montant'        => $payload['montant_total'],
                'mode_paiement'        => $payload['mode_paiement'],
                'reference'            => $transactionId,
                'statut'               => 'PAYE',
            ]);


            // Dates de la réservation
            $resStart = Carbon::parse($payload['date_debut'])->startOfDay();
            $resEnd   = Carbon::parse($payload['date_fin'])->startOfDay();

            // On récupère les plages "disponible" de ce logement qui se chevauchent
            $slots = LogementDisponibilite::where('logement_id', $payload['logement_id'])
                ->where('statut', 'disponible')
                ->where(function ($q) use ($resStart, $resEnd) {
                    $q->whereBetween('date_debut', [$resStart, $resEnd])
                        ->orWhereBetween('date_fin', [$resStart, $resEnd])
                        ->orWhere(function ($q2) use ($resStart, $resEnd) {
                            $q2->where('date_debut', '<=', $resStart)
                                ->where('date_fin', '>=', $resEnd);
                        });
                })
                ->get();

            foreach ($slots as $slot) {
                $slotStart = Carbon::parse($slot->date_debut)->startOfDay();
                $slotEnd   = Carbon::parse($slot->date_fin)->startOfDay();

                // On supprime l’ancienne plage dispo (ex: [04 → 12])
                $slot->delete();

                // 1) Partie avant la réservation : [slotStart → (resStart - 1 jour)]
                if ($slotStart < $resStart) {
                    $beforeEnd = $resStart->copy()->subDay(); // veille du début de résa

                    LogementDisponibilite::create([
                        'logement_id' => $slot->logement_id,
                        'date_debut'  => $slotStart->toDateString(),
                        'date_fin'    => $beforeEnd->toDateString(),
                        'statut'      => 'disponible',
                    ]);
                }

                // 2) Période réservée : [resStart → resEnd] (inclusif comme tu veux)
                LogementDisponibilite::create([
                    'logement_id' => $slot->logement_id,
                    'date_debut'  => $resStart->toDateString(),
                    'date_fin'    => $resEnd->toDateString(),
                    'statut'      => 'reserver',
                ]);

                // 3) Partie après la réservation : [(resEnd + 1 jour) → slotEnd]
                if ($resEnd < $slotEnd) {
                    $afterStart = $resEnd->copy()->addDay(); // jour après la résa

                    LogementDisponibilite::create([
                        'logement_id' => $slot->logement_id,
                        'date_debut'  => $afterStart->toDateString(),
                        'date_fin'    => $slotEnd->toDateString(),
                        'statut'      => 'disponible',
                    ]);
                }
            }

            app('App\Services\DispatchingService')->dispatchPaiement($payload, $reservation);

            // On va avoir besoin du user et du logement pour mails / notif
            $user     = User::find($payload['user_id'] ?? null);
            $logement = Logement::with('photos', 'user')->find($payload['logement_id'] ?? null);

            // 1) Notification succès pour l'utilisateur
            if ($payload['user_id']) {
                Notification::create([
                    'user_id' => $user->id,
                    'type'    => 'reservation',
                    'title'   => 'Réservation confirmée',
                    'message' => "Votre réservation pour « {$logement->titre} » est confirmée.",
                    'data'    => [
                        'reservation_id' => $reservation->id,
                        'logement_id'    => $logement->id,
                        'date_debut'     => $reservation->date_debut,
                        'date_fin'       => $reservation->date_fin,
                        'montant'  => $reservation->montant_total,
                        'devise'         => $reservation->devise,
                    ],
                ]);
            }

            if ($user) {
                Mail::to($user->email)->send(
                    new ReservationSuccessMail($reservation)
                );
            }
            return redirect()->route('hoost.logements.show', $payload['logement_id'])->with('success', "Votre paiement a été confirmé, la réservation est validée 🎉");
        } catch (Exception $e) {
            return redirect()->route('hoost.logements.show', $payload['logement_id'] ?? null)->with('error', "Erreur lors de la vérification du paiement : " . $e->getMessage());
        }
    }


    public function kkiapayCallback(Request $request)
    {
        $transactionId = $request->query('transaction_id');
        $secureToken   = $request->query('token');

        if (!$transactionId || !$secureToken) {
            return back()->with('error', "Transaction Kkiapay invalide.");
        }

        // Récupération du payload
        try {
            $payload = json_decode(Crypt::decryptString($secureToken), true);
        } catch (Exception $e) {
            return back()->with('error', "Token invalide.");
        }

        // // Vérification auprès de Kkiapay
        // $response = Http::withHeaders([
        //     'Authorization' => "Bearer " . config('services.kkiapay.private_key'),
        //     'Accept'        => 'application/json',
        // ])->post("https://api.kkiapay.me/api/v1/transactions/status", [
        //     "transactionId" => $transactionId,
        // ]);

        // 2) Choisir la bonne base URL (sandbox / live)
        // $baseUrl = config('services.kkiapay.sandbox')
        //     ? 'https://api-sandbox.kkiapay.me'
        //     : 'https://api.kkiapay.me';

        $baseUrl = config('services.kkiapay.live')
            ? 'https://api.kkiapay.me'
            : 'https://api-sandbox.kkiapay.me';

        // 3) Appel API de vérification avec les bons headers
        $response = Http::withHeaders([
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
            'X-SECRET-KEY'  => config('services.kkiapay.secret'),
            'X-API-KEY'     => config('services.kkiapay.public_key'),
            'X-PRIVATE-KEY' => config('services.kkiapay.private_key'),
        ])->post($baseUrl . '/api/v1/transactions/status', [
            'transactionId' => $transactionId,
        ]);

        //dd($response);

        if (!$response->successful()) {
            return back()->with('error', "Erreur API Kkiapay.");
        }

        $tx = $response->json();

        if (($tx['status'] ?? '') !== 'SUCCESS') {
            return back()->with('error', "Paiement non validé par Kkiapay.");
        }

        //Ici tu réutilises EXACTEMENT ton code de fedapayCallback :
        // - vérifier disponibilité
        // - créer réservation
        // - créer contribution
        // - bloquer dates
        // - envoyer mail
        // - envoyer notification

        // EXEMPLE rapide :
        $reservation = Reservation::create([
            'user_id'      => $payload['user_id'],
            'logement_id'  => $payload['logement_id'],
            'date_debut'   => $payload['date_debut'],
            'date_fin'     => $payload['date_fin'],
            'nb_nuits'     => $payload['nb_nuits'],
            'projet_id'    => $payload['projet_id'],
            'nb_voyageurs' => $payload['nb_voyageur'],
            'montant'      => $payload['montant_total'],
            'reference'    => $transactionId,
            'mode_paiement' => $payload['mode_paiement'],
            'statut'       => 'PAYE',
        ]);

        // Dates de la réservation
        $resStart = Carbon::parse($payload['date_debut'])->startOfDay();
        $resEnd   = Carbon::parse($payload['date_fin'])->startOfDay();

        // On récupère les plages "disponible" de ce logement qui se chevauchent
        $slots = LogementDisponibilite::where('logement_id', $payload['logement_id'])
            ->where('statut', 'disponible')
            ->where(function ($q) use ($resStart, $resEnd) {
                $q->whereBetween('date_debut', [$resStart, $resEnd])
                    ->orWhereBetween('date_fin', [$resStart, $resEnd])
                    ->orWhere(function ($q2) use ($resStart, $resEnd) {
                        $q2->where('date_debut', '<=', $resStart)
                            ->where('date_fin', '>=', $resEnd);
                    });
            })
            ->get();

        foreach ($slots as $slot) {
            $slotStart = Carbon::parse($slot->date_debut)->startOfDay();
            $slotEnd   = Carbon::parse($slot->date_fin)->startOfDay();

            // On supprime l’ancienne plage dispo (ex: [04 → 12])
            $slot->delete();

            // 1) Partie avant la réservation : [slotStart → (resStart - 1 jour)]
            if ($slotStart < $resStart) {
                $beforeEnd = $resStart->copy()->subDay(); // veille du début de résa

                LogementDisponibilite::create([
                    'logement_id' => $slot->logement_id,
                    'date_debut'  => $slotStart->toDateString(),
                    'date_fin'    => $beforeEnd->toDateString(),
                    'statut'      => 'disponible',
                ]);
            }

            // 2) Période réservée : [resStart → resEnd] (inclusif comme tu veux)
            LogementDisponibilite::create([
                'logement_id' => $slot->logement_id,
                'date_debut'  => $resStart->toDateString(),
                'date_fin'    => $resEnd->toDateString(),
                'statut'      => 'reserver',
            ]);

            // 3) Partie après la réservation : [(resEnd + 1 jour) → slotEnd]
            if ($resEnd < $slotEnd) {
                $afterStart = $resEnd->copy()->addDay(); // jour après la résa

                LogementDisponibilite::create([
                    'logement_id' => $slot->logement_id,
                    'date_debut'  => $afterStart->toDateString(),
                    'date_fin'    => $slotEnd->toDateString(),
                    'statut'      => 'disponible',
                ]);
            }
        }

        app('App\Services\DispatchingService')->dispatchPaiement($payload, $reservation);

        // On va avoir besoin du user et du logement pour mails / notif
        $user     = User::find($payload['user_id'] ?? null);
        $logement = Logement::with('photos', 'user')->find($payload['logement_id'] ?? null);

        // 1) Notification succès pour l'utilisateur
        if ($payload['user_id']) {
            Notification::create([
                'user_id' => $user->id,
                'type'    => 'reservation',
                'title'   => 'Réservation confirmée',
                'message' => "Votre réservation pour « {$logement->titre} » est confirmée.",
                'data'    => [
                    'reservation_id' => $reservation->id,
                    'logement_id'    => $logement->id,
                    'date_debut'     => $reservation->date_debut,
                    'date_fin'       => $reservation->date_fin,
                    'montant'  => $reservation->montant_total,
                    'devise'         => $reservation->devise,
                ],
            ]);
        }

        if ($user) {
           // $prefs = $user->notificationPreferences;
           // dd($prefs->email);
           // if($prefs->email){
              Mail::to($user->email)->send(
                new ReservationSuccessMail($reservation));
            //}
        }
        return redirect()->route('hoost.logements.show', $payload['logement_id']) ->with('success', "Votre paiement a été confirmé");
    }


    public function paypalCallback(Request $request)
    {
        $orderId = $request->get('token');
        $secureToken = $request->get('token_payload');

        if (!$orderId || !$secureToken) {
            return back()->with('error', 'Paiement PayPal invalide.');
        }

        try {
            $payload = json_decode(Crypt::decryptString($secureToken), true);
        } catch (\Exception $e) {
            return back()->with('error', 'Token PayPal invalide.');
        }

        $response = app(\App\Services\PayPalService::class)
            ->captureOrder($orderId);

        if (($response->result->status ?? '') !== 'COMPLETED') {
            return back()->with('error', 'Paiement PayPal non confirmé.');
        }
        dd("ok ça passe");
        /**
         * À PARTIR D’ICI :
         * COPIE EXACTEMENT le code métier de fedapayCallback :
         * - vérifier disponibilité
         * - créer réservation
         * - bloquer dates
         * - dispatchPaiement
         * - mails & notifications
         */

    }


    public function index(Request $request)
    {
        $reservations = Reservation::with(['user', 'logement'])
            ->orderBy('date_debut', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('reservations.admin.index', compact('reservations'));
    }

    public function reservations()
    {
        $user = Auth::user();
        $reservations = $user->reservations()
            ->with(['logement'])
            ->orderBy('date_debut', 'desc')
            ->paginate(6)->withQueryString();
        return view('reservations.index', compact('reservations'));
    }


    public function sejours()
    {
        $user = Auth::user();
        $reservations = $user->reservations()
        ->with(['logement'])
        ->where('date_fin', '<', now())
        ->orderBy('date_debut', 'desc')
        ->paginate(6)
        ->withQueryString();
        return view('reservations.history', compact('reservations'));
    }
}
