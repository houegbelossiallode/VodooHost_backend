<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Paiement;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use FedaPay\FedaPay;
use FedaPay\Transaction;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PaiementController extends Controller
{
    // Afficher le formulaire de paiement
    // public function create(Reservation $reservation)
    // {
    //     $this->authorize('view', $reservation);
        
    //     if ($reservation->statut !== Reservation::STATUT_EN_ATTENTE_PAIEMENT) {
    //         return redirect()->route('hoost.reservations.show', $reservation)
    //             ->with('error', 'Cette réservation ne nécessite pas de paiement.');
    //     }

    //     return view('paiements.create', compact('reservation'));
    // }

    // // Traiter le paiement
    // public function store(Request $request, Reservation $reservation)
    // {
    //     $this->authorize('update', $reservation);

    //     $request->validate([
    //         'mode_paiement' => 'required|in:carte,mtn,moov',
    //         'telephone' => 'required_if:mode_paiement,mtn,moov|string|max:20',
    //     ]);

    //     try {
    //         // Initialiser FedaPay avec la clé API
    //         FedaPay::setApiKey(config('services.fedapay.secret_key'));
    //         FedaPay::setEnvironment(config('services.fedapay.environment'));

    //         $montant = $reservation->mode_paiement === 'acompte' 
    //             ? $reservation->montant_total * 0.3 
    //             : $reservation->montant_total;

    //         // Créer une transaction FedaPay
    //         $transaction = Transaction::create([
    //             'description' => 'Réservation #' . $reservation->id . ' - ' . $reservation->logement->titre,
    //             'amount' => $montant,
    //             'currency' => [
    //                 'iso' => 'XOF'
    //             ],
    //             'callback_url' => route('hoost.paiement.callback'),
    //             'customer' => [
    //                 'firstname' => $reservation->user->prenom ?? 'Client',
    //                 'lastname' => $reservation->user->nom ?? 'Anonyme',
    //                 'email' => $reservation->user->email,
    //                 'phone_number' => [
    //                     'number' => $request->telephone ?? $reservation->user->telephone ?? '00000000',
    //                     'country' => 'bj'
    //                 ]
    //             ]
    //         ]);

    //         // Générer un token de paiement
    //         $token = $transaction->generateToken();

    //         // Enregistrer le paiement en attente
    //         $paiement = $reservation->paiements()->create([
    //             'montant' => $montant,
    //             'devise' => 'XOF',
    //             'methode' => $request->mode_paiement,
    //             'statut' => 'en_attente',
    //             'reference' => $transaction->reference,
    //             'transaction_id' => $transaction->id,
    //         ]);

    //         // Rediriger vers la page de paiement FedaPay
    //         return redirect($token->url);

    //     } catch (\Exception $e) {
    //         return back()->with('error', 'Une erreur est survenue lors de la création du paiement: ' . $e->getMessage());
    //     }
    // }

    /**
     * Affiche la liste des transactions avec filtrage
     */
    public function index(Request $request)
    {
        $query = Paiement::with(['reservation', 'reservation.user', 'reservation.logement'])
            ->latest();

        // Filtre par date
        if ($request->filled('date_debut')) {
            $query->whereDate('created_at', '>=', $request->date_debut);
        }

        if ($request->filled('date_fin')) {
            $query->whereDate('created_at', '<=', $request->date_fin);
        }

        // Filtre par statut
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        // Filtre par méthode de paiement
        if ($request->filled('methode')) {
            $query->where('methode', $request->methode);
        }

        $transactions = $query->paginate(15);
        
        // Statistiques
        $totalTransactions = $transactions->total();
        $totalMontant = $query->sum('montant');
        
        // Si des dates sont sélectionnées, on calcule le total pour la période
        $periodeMontant = 0;
        if ($request->filled('date_debut') || $request->filled('date_fin')) {
            $periodeQuery = Paiement::query();
            
            if ($request->filled('date_debut')) {
                $periodeQuery->whereDate('created_at', '>=', $request->date_debut);
            }
            
            if ($request->filled('date_fin')) {
                $periodeQuery->whereDate('created_at', '<=', $request->date_fin);
            }
            
            $periodeMontant = $periodeQuery->sum('montant');
        }

        return view('paiements.index', compact(
            'transactions', 
            'totalTransactions', 
            'totalMontant',
            'periodeMontant'
        ));
    }

    // Callback de FedaPay après paiement
    // public function callback(Request $request)
    // {
    //     $transactionId = $request->input('transaction_id');
        
    //     try {
    //         // Récupérer la transaction depuis FedaPay
    //         $transaction = Transaction::retrieve($transactionId);
            
    //         // Trouver le paiement correspondant
    //         $paiement = Paiement::where('transaction_id', $transaction->id)->firstOrFail();
    //         $reservation = $paiement->reservation;
            
    //         // Mettre à jour le statut du paiement
    //         $paiement->update([
    //             'statut' => $transaction->status,
    //             'donnees_reponse' => json_encode($transaction->toArray()),
    //         ]);
            
    //         // Mettre à jour le statut de la réservation si le paiement est réussi
    //         if ($transaction->status === 'approved') {
    //             $reservation->update(['statut' => Reservation::STATUT_CONFIRMEE]);
                
    //             // Mettre à jour le statut de la contribution
    //             if ($reservation->contribution) {
    //                 $reservation->contribution->update(['statut' => 'paye']);
    //             }
                
    //             return redirect()
    //                 ->route('hoost.reservations.show', $reservation)
    //                 ->with('success', 'Paiement effectué avec succès !');
    //         }
            
    //         return redirect()
    //             ->route('hoost.reservations.show', $reservation)
    //             ->with('error', 'Le paiement n\'a pas pu être validé.');
                
    //     } catch (\Exception $e) {
    //         \Log::error('Erreur de callback FedaPay: ' . $e->getMessage());
    //         return redirect()
    //             ->route('hoost.home')
    //             ->with('error', 'Une erreur est survenue lors du traitement de votre paiement.');
    //     }
    // }
}
