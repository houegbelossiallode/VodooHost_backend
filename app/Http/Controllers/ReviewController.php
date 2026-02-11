<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Review;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(){
        $user = Auth::user();
        $reviews = Review::where('reviewer_id',$user->id)->latest()->get();
        return view('reviews.index',compact('reviews'));
    }


    public function create(Reservation $reservation, User $user)
    {
        //dd($user);
        $visitor = Auth::user();

        // Sécurité : c’est bien le client de la réservation
        // if ($reservation->user_id !== $visitor->id) {
        //     abort(403);
        // }

        // Option : on vérifie que le séjour est bien terminé
        if ($reservation->date_fin > now()) {
            return redirect()->route('hoost.reservations.history')->with('error', 'Vous pourrez laisser un avis après la fin de votre séjour.');
        }

        // S'il a déjà laissé un avis, on peut le précharger pour édition
        $existingReview = Review::where('reservation_id', $reservation->id)
            ->where('reviewer_id', $visitor->id)
            ->where('target_user_id', $user->id)
            ->first();

        return view('reviews.create', [
            'reservation'    => $reservation,
            'reviewedUser'   => $user,
            'existingReview' => $existingReview,
        ]);
    }



    public function store(Request $request, Reservation $reservation, User $user)
    {
        //dd($request);
        try{
          $visitor = Auth::user();
        // 1) Validation
        $data = $request->validate([
            'critere'     => 'required',
            'rating'      => ['required', 'integer', 'min:1', 'max:10'],
            'comment' => ['required', 'string', 'max:5000'],
        ], [
            'critere.required' => 'Veuillez choisir un critère.',
            'rating.required'  => 'Veuillez sélectionner une note.',
        ]);

        // 2) Création ou mise à jour de l’avis
        // (si tu veux empêcher plusieurs avis pour la même réservation + même personne)
        $review = Review::updateOrCreate(
            [
                'reservation_id'   => $reservation->id,
                'reviewer_id'    => $visitor->id,
                'target_user_id' => $user->id,
                'critere'          => $data['critere'],
            ],
            [
                'rating'      => $data['rating'],
                'comment' => $data['comment'],
            ]
        );
        return redirect()->route('hoost.reservations.history')->with('success', 'Merci pour votre avis !');
        }catch(Exception $e){
            return redirect()->route('hoost.reservations.history')->with('error', 'Une erreur est survenue' . $e->getMessage());
        }
    }


    /**
     * Afficher le formulaire d’édition d’un avis
     */
    public function edit(Review $review)
    {
        //dd('jes suis ici');
        $visitor = Auth::user();
        // Sécurité : seul l’auteur de l’avis peut l’éditer
        if ($review->reviewer_id !== $visitor->id) {
            abort(403, 'Vous ne pouvez pas modifier cet avis.');
        }

        // On récupère la réservation et la personne évaluée
        $reservation  = Reservation::findOrFail($review->reservation_id);
        $reviewedUser = User::findOrFail($review->target_user_id);
      

        // Si tu n’as pas encore les relations, tu peux aussi faire :
        // $reservation  = Reservation::find($review->reservation_id);
        // $reviewedUser = User::find($review->target_user_id);

        return view('reviews.edit', [
            'review'      => $review,
            'reservation' => $reservation,
            'reviewedUser'=> $reviewedUser,
        ]);
    }

    /**
     * Mettre à jour l’avis
     */
    public function update(Request $request, Review $review)
    {
        
        try {
            $visitor = Auth::user();
            // Sécurité : seul l’auteur peut modifier
            if ($review->reviewer_id !== $visitor->id) {
                abort(403, 'Vous ne pouvez pas modifier cet avis.');
            }

            // Validation
            $data = $request->validate([
                'critere'   => 'required',
                'rating'    => ['required', 'integer', 'min:1', 'max:10'],
                'comment'   => ['required', 'string', 'max:5000'],
            ], [
                'critere.required' => 'Veuillez choisir un critère.',
                'rating.required'  => 'Veuillez sélectionner une note.',
            ]);

            // Mise à jour
            $review->update([
                'critere' => $data['critere'],
                'rating'  => $data['rating'],
                'comment' => $data['comment'],
            ]);
            return redirect()->route('hoost.reservations.history')->with('success', 'Votre avis a été mis à jour avec succès');
        } catch (Exception $e) {
            return back()->with('error', 'Erreur lors de la mise à jour de l’avis : ' . $e->getMessage());
        }
    }


}
