<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentaireController extends Controller
{
    public function index(Request $request){
        try{
          //Récupération du type de tri (par défaut : "latest")
        $sort = $request->get('sort','latest');
        //Base de la requête : avis sur les logements de l'hôte connecté
        $query = Avis::where('actif','OUI')->with(['user','logement'])
            ->whereHas('logement', function ($q) {
                $q->where('user_id',Auth::id());
            });
        //Appliquer le tri selon la valeur du select
        switch ($sort) {
            case 'oldest':      // plus anciens
                $query->orderBy('created_at', 'asc');
                break;
            case 'rating':      // meilleure note
                $query->orderBy('notes', 'desc');
                break;
            case 'latest':      // plus récents
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        //  Pagination (6 par page) + conservation des paramètres dans l'URL
        $reviews = $query->paginate(6)->appends(['sort' => $sort]);

        //  Compteur d'avis "nouveaux"
        // Ici on prend les avis créés aujourd'hui, tu pourras affiner plus tard (read_at, etc.)
        $newReviewsCount = Avis::where('actif','OUI')->whereHas('logement', function ($q) {
                $q->where('user_id', Auth::id());
            })->whereDate('created_at', now()->toDateString())->count();
        return view('commentaires.index', compact('reviews', 'newReviewsCount', 'sort'));
        } catch(Exception $e){
         return redirect()->back()->with('error','Une erreur est survenue' . $e->getMessage());
        }
        
    }


    public function avis(Request $request){
        try{
        //Récupération du type de tri (par défaut : "latest")
        $sort = $request->get('sort','latest');
        //Base de la requête : avis sur les logements de l'hôte connecté
        $query = Avis::where('actif','OUI')->where('user_id',Auth::id());
        //Appliquer le tri selon la valeur du select
        switch ($sort) {
            case 'oldest':      // plus anciens
                $query->orderBy('created_at', 'asc');
                break;

            case 'rating':      // meilleure note
                $query->orderBy('notes', 'desc');
                break;

            case 'latest':      // plus récents
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        //  Pagination (6 par page) + conservation des paramètres dans l'URL
        $reviews = $query->paginate(6)->appends(['sort' => $sort]);
        //  Compteur d'avis "nouveaux"
        // Ici on prend les avis créés aujourd'hui, tu pourras affiner plus tard (read_at, etc.)
        $newReviewsCount = Avis::where('actif','OUI')->where('user_id', Auth::id())
            ->whereDate('created_at', now()->toDateString())->count();
        return view('commentaires.visiteurs', compact('reviews', 'newReviewsCount', 'sort'));
        }catch(Exception $e){
         return redirect()->back()->with('error','Une erreur est survenue' . $e->getMessage());
        }
    }


    public function store(Request $request){

        try{
        
        $data = $request->validate([
            'logement_id' => ['required', 'exists:logements,id'],
            'note'        => ['required', 'integer', 'min:1', 'max:10'],
            'commentaire' => ['required', 'string', 'max:255'],
        ], [
            'logement_id.required' => 'Logement manquant.',
            'logement_id.exists'   => 'Ce logement est introuvable.',
            'note.required'        => 'Merci de donner une note.',
            'note.min'             => 'La note minimale est 1.',
            'note.max'             => 'La note maximale est 10.',
            'commentaire.required' => 'Merci de saisir un commentaire.',
        ]);

        $user = Auth::user();

        Avis::create([
           'user_id'=> $user->id,
           'logement_id'=> $data['logement_id'],
           'notes'=> $data['note'],
           'commentaire'=> $data['commentaire']
        ]);

         return redirect()->back()->with('success', 'Merci, votre avis a été enregistré');
        }
        catch(Exception $e){
         return redirect()->back()->with('error','Une erreur est survenue' . $e->getMessage());
        }
    }


}
