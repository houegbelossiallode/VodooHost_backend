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
        $preferences = $user->preferences;
        
        $divinitesPreferees = $preferences?->divinites_preferees ?? [];
        if (!is_array($divinitesPreferees)) {
            $divinitesPreferees = json_decode($divinitesPreferees, true) ?? [];
        }

        if (empty($divinitesPreferees)) {
            return redirect()->route('hoost.preferences.questionnaire')
                ->with('info', 'Veuillez d\'abord compléter le questionnaire pour voir vos recommandations.');
        }

        // Récupérer les logements recommandés basés sur les divinités préférées
        $logements = Logement::whereHas('divinites', function($query) use ($divinitesPreferees) {
            $query->whereIn('divinites.id', $divinitesPreferees);
        })
        ->with(['photos', 'divinites', 'user'])
        ->inRandomOrder()
        ->take(6)
        ->get();

        $divinites = Divinite::whereIn('id', $divinitesPreferees)->get();

        return view('recommendations.index', [
            'logements' => $logements,
            'divinites' => $divinites,
            'preferences' => $preferences,
            'user' => $user,
        ]);
    }
}
