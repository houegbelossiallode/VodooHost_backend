<?php

namespace App\Http\Controllers;

use App\Models\Logement;
use App\Models\Rituel;
use App\Models\Divinite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class RecommendationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // if (!$user->hasCompletedQuestionnaire()) {
        //     return redirect()->route('hoost.preferences.questionnaire')
        //         ->with('info', 'Veuillez d\'abord compléter le questionnaire pour voir vos recommandations.');
        // }

        $preferences = $user->preferences;
        
        // Récupérer les logements recommandés basés sur les divinités préférées
        $logements = Logement::whereHas('divinites', function($query) use ($preferences) {
            $query->whereIn('divinites.id', $preferences->divinites_preferees);
        })
        ->with(['photos', 'divinites', 'user'])
        ->inRandomOrder()
        ->take(6)
        ->get();

        //dd($logements);

        // Si l'utilisateur souhaite assister à un rituel
        // $rituels = [];
        // if ($preferences->assister_rituel) {
        //     $rituels = Rituel::whereHas('divinites', function($query) use ($preferences) {
        //         $query->whereIn('divinites.id', $preferences->divinites_preferees);
        //     })
        //     ->with(['divinites', 'user'])
        //     ->take(3)
        //     ->get();
        // }

        // Informations sur les divinités sélectionnées
        $divinites = Divinite::whereIn('id', $preferences->divinites_preferees)->get();

        return view('recommendations.index', [
            'logements' => $logements,
            //'rituels' => $rituels,
            'divinites' => $divinites,
            'preferences' => $preferences
        ]);
    }
}
