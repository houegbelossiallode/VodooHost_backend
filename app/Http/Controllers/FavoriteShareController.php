<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteShareController extends Controller
{
    public function show(string $slug)
    {
        $list = Favorite::where('lien_partage', $slug)
            ->where('est_partage', true)
            ->with(['items.logement' => fn($q) => $q->select('id','titre','ville','prix_par_nuit')])
            ->firstOrFail();

        return view('favorites.share', compact('list'));
    }
}
