<?php

namespace App\Http\Controllers;

use App\Models\FavoriLogement;
use App\Models\Favorite;
use App\Models\Logement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{
    // private function identity(): array {
    //     if (Auth::check()) return ['user_id' => Auth::id(), 'session_key' => null];
    //     // si tu acceptes les visiteurs :
    //     if (!session()->has('favorites_session_key')) {
    //         session(['favorites_session_key' => 'guest_'.Str::uuid()]);
    //     }
    //     return ['user_id' => null, 'session_key' => session('favorites_session_key')];
    // }

    // private function scopeLists() {
    //     $id = $this->identity();
    //     return Favorite::where($id);
    // }

    public function index()
    {
        $lists = Favorite::where('user_id', Auth::id())
        ->with([
            'items.logement' => fn($q) => $q->select('id', 'titre', 'prix_par_nuit')
        ])
        ->latest()
        ->get();

        return view('favorites.index', compact('lists'));
    }

    // public function storeList(Request $request)
    // {
    //     $data = $request->validate([
    //         'libelle'     => ['required','string','max:50'],
    //         'logement_id' => ['nullable','exists:logements,id'],
    //     ]);

    //     $list = Favorite::create(array_merge($this->identity(), [
    //         'libelle'      => $data['libelle'],
    //         'est_partage'  => false,
    //         // 'lien_partage' généré en boot()
    //     ]));

    //     if (!empty($data['logement_id'])) {
    //         FavoriLogement::firstOrCreate([
    //             'favorite_id' => $list->id,
    //             'logement_id' => $data['logement_id'],
    //         ]);
    //     }

    //     return back()->with('success', 'Liste créée.');
    // }

    // public function renameList(Request $request, Favorite $favorite)
    // {
    //     //$this->authorizeAccess($favorite);

    //     $data = $request->validate([
    //         'libelle' => ['required','string','max:50'],
    //     ]);

    //     $favorite->update(['libelle' => $data['libelle']]);

    //     return back()->with('success', 'Liste renommée.');
    // }

    public function renameList(Request $request, Favorite $favorite)
{
    $data = $request->validate([
        'libelle' => ['required','string','max:50'],
    ]);

    $favorite->update(['libelle' => $data['libelle']]);
    return back()->with('success', 'Liste renommée.');
}

public function deleteList(Favorite $favorite)
{
    $favorite->delete();
    return back()->with('success', 'Liste supprimée.');
}

    
    // Créer la liste + y attacher le logement
    public function storeList(Request $request)
    {
        $data = $request->validate([
            'libelle'     => ['required','string','max:50'],
            'logement_id' => ['required','exists:logements,id'],
        ]);

        $list = Favorite::create([
            'user_id'      => Auth::id(),
            'libelle'      => $data['libelle'],
            'actif'        => 'OUI',
        ]);

        $list->logements()->syncWithoutDetaching([$data['logement_id']]);

        return back()->with('success', 'Liste créée et logement ajouté.');
    }

    // Ajouter à une liste existante
    public function add(Request $request, Favorite $favorite)
    {
        //dd($favorite);
        //$listId = $list->id ?: $request->input('favorite_id');
        
        
        $data = $request->validate([
            'logement_id' => ['required','exists:logements,id'],
        ]);

        $favorite->logements()->syncWithoutDetaching([$data['logement_id']]);

        return back()->with('success', 'Logement ajouté à la liste.');
    }

    public function removeItem(Favorite $favorite, $logementId)
    {
        // Vérifiez d'abord si le logement existe
        $logement = \App\Models\Logement::findOrFail($logementId);
        
        // Supprimez la relation
        $favorite->logements()->detach($logementId);

        // Vérifiez si la liste est vide après suppression
        if ($favorite->logements()->count() === 0) {
            $favorite->delete();
            return redirect()->route('hoost.favorites.index')->with('success', 'Logement retiré et liste supprimée car elle est vide.');
        }

        return back()->with('success', 'Logement retiré de la liste.');
    }

    public function toggleShare(Favorite $favorite)
    {
        $this->authorizeFavorite($favorite);

        // if (! $favorite->est_partage) {
        //     // On active le partage
        //     if (!$favorite->lien_partage) {
        //         $favorite->lien_partage = Str::random(32);
        //     }
        //     $favorite->est_partage = true;
        // } else {
        //     // On désactive le partage
        //     $favorite->est_partage = false;
        // }
        // $favorite->save();

        // Copier la logique EXACTE que tu avais
    if (! $favorite->est_partage) {
        // On active le partage
        if (!$favorite->lien_partage) {
            $favorite->lien_partage = Str::random(48);
        }
        $newValue = true;
    } else {
        // On désactive le partage
        $newValue = false;
    }

    //On n'utilise PAS $favorite->save() car Eloquent envoie 1/0 → erreur PostgreSQL
    DB::table('favorites')
        ->where('id', $favorite->id)
        ->update([
            'lien_partage' => $favorite->lien_partage,
            'est_partage'  => DB::raw($newValue ? 'TRUE' : 'FALSE'),
        ]);

    // Recharger depuis la BDD
    $favorite->refresh();

        return back()->with('success', $favorite->est_partage
            ? 'Le partage a été activé.'
            : 'Le partage a été désactivé.');
    }

    
    public function showPublic(string $token)
    {
        $favorite = Favorite::with(['items.logement.photos'])
            ->where('lien_partage', $token)
             ->whereRaw('est_partage = TRUE')
            //->where('est_partage', true)
            ->firstOrFail();

        // Vue de partage en lecture seule (à créer, ex: favorites.public)
        return view('favorites.public', compact('favorite'));
    }

    protected function authorizeFavorite(Favorite $favorite): void
    {
        if ($favorite->user_id !== Auth::id()) {
            abort(403);
        }
    }

}
