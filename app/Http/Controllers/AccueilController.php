<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Photo;
use App\Models\Projet;
use App\Models\Logement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Avis;
use App\Models\Temoignage;
use App\Models\TypeLogement;

class AccueilController extends Controller
{
    public function index()
    {
        // Récupérer les logements avec leurs photos et le propriétaire
        $logements = Logement::where('actif','OUI')
            ->with(['photos', 'user','typelogement'])
            ->latest()
            ->take(6)
            ->get();
        $hotes = User::where('actif','OUI')->whereHas('logements')
                ->withCount('logements')   // pour éviter le N+1 sur $hote->logements->count()
                ->get();
        $projets = Projet::where('actif','OUI')->latest()->take(3)->get();
        // $temoignages = Temoignage::with('user')->latest()->get();
        $avis = Avis::where('actif','OUI')->with('user')->latest()->get();
        $typelogements = TypeLogement::where('actif','OUI')->orderBy('libelle')->get();
        return view('accueil', compact('logements', 'hotes', 'projets','avis','typelogements'));
    }
}
