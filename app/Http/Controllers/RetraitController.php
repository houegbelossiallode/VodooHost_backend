<?php

namespace App\Http\Controllers;

use App\Models\Retrait;
use App\Models\Transaction;
use App\Models\Compte;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RetraitController extends Controller
{
    /**
     * Afficher le formulaire de demande de retrait
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Récupérer le compte de l'utilisateur
        $compte = Compte::where('user_id', $user->id)->first();
        if(!$compte){
            return redirect()->back()->with('error','Vous n\'avez pas de compte sur Voodoo Hoost');
        }
        $solde  = $compte->solde;
        // Filtre optionnel sur le statut
        $statut = $request->input('statut'); // en_attente, valide, refuse, etc.

        $query = Retrait::where('compte_id', $compte->id)
            ->orderBy('created_at', 'desc');

        if (!empty($statut)) {
            $query->where('statut', $statut);
        }

        $retraits = $query->paginate(10)->withQueryString();

        return view('revenus.retraits.index', compact('retraits', 'solde', 'statut'));
    }

    public function create()
    {
        $user = Auth::user();
        $compte = Compte::where('user_id', $user->id)->firstOrFail();
        $solde = $compte->solde;
        $retraits = Retrait::where('compte_id', $compte->id)
            ->orderBy('created_at', 'desc')->get();

        return view('revenus.retraits.create', compact('solde','retraits'));
    }


    public function store(Request $request)
    {
        try {
        // 1) Construire les règles dynamiquement selon le mode
        $rules = [
            'montant' => ['required'],
            'mode'    => ['required', 'in:mobile_money,card'],
        ];

        // Si Mobile Money => on exige les champs Mobile Money
        if ($request->input('mode') === 'mobile_money') {
            $rules['mobile_money_number'] = ['required', 'numeric'];
            $rules['mobile_money_name']   = ['required', 'string', 'max:100'];
        }

        // Si Carte bancaire => on exige les champs Carte
        if ($request->input('mode') === 'card') {
            $rules['card_holder'] = ['required', 'string', 'max:100'];
            $rules['card_number'] = ['required', 'numeric'];
        }

        $messages = [
            'montant.required' => 'Veuillez saisir un montant.',
            'montant.numeric'  => 'Le montant doit être un nombre.',
            'montant.min'      => 'Le montant minimum de retrait est de 1 000 FCFA.',

            'mode.required' => 'Veuillez choisir un mode de retrait.',
            'mode.in'       => 'Mode de retrait non valide.',

            'mobile_money_number.required' => 'Le numéro Mobile Money est requis pour ce mode de retrait.',
            'mobile_money_name.required'   => 'Le nom du titulaire Mobile Money est requis.',

            'card_holder.required' => 'Le nom du titulaire de la carte est requis.',
            'card_number.required' => 'Le numéro de la carte est requis.',
        ];

        // 2) Validation AVANT la transaction et hors try/catch
        $validated = $request->validate($rules, $messages);

        $user    = Auth::user();
        $montant = $validated['montant'];

        // 3) Vérifier si l'utilisateur a un compte
        $compte = Compte::where('user_id', $user->id)->firstOrFail();

        // 4) Vérifier si le solde est suffisant
        if ($compte->solde < $montant) {
            return back()->with('error', 'Solde insuffisant pour effectuer ce retrait.')->withInput();
        }

        // 5) Adapter methode + numero_compte selon le mode choisi
        if ($validated['mode'] === 'mobile_money') {
            $methode      = 'mobile_money';
            $numeroCompte = $validated['mobile_money_number'];
            $nom_titulaire = $validated['mobile_money_name'];
           //dd($nom_titulaire);
        } else {
            $methode      = 'card';
            $numeroCompte = $validated['card_number'];
            $nom_titulaire = $validated['card_holder'];
           // dd($nom_titulaire);
        }
          // dd($nom_titulaire);
            // 6) Créer la demande de retrait
            $retrait = Retrait::create([
                'compte_id'     => $compte->id,
                'montant'       => $montant,
                'statut'        => 'en_attente',
                'methode'       => $methode,
                'numero_compte' => $numeroCompte,
                'nom_titulaire'  => $nom_titulaire,
            ]);

            // 7) Créer la transaction de débit
            $transaction = Transaction::create([
                'montant'     => $montant,
                'type'        => 'retrait',
                'compte_id'   => $compte->id,
            ]);

            // 8) Mettre à jour le solde du compte
            $compte->decrement('solde', $montant);
            return redirect()->route('hoost.retraits.index')->with('success', 'Votre demande de retrait a été enregistrée avec succès. Elle sera traitée dans les plus brefs délais.');
        } catch (Exception $e) {
            return back()->with('error', 'Erreur lors de la demande de retrait : ' . $e->getMessage());
        }
    }




    public function historique()
    {
        $user = Auth::user();
        $retraits = Retrait::whereHas('compte', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->with('transactions')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('revenus.retraits.historique', compact('retraits'));
    }
}
