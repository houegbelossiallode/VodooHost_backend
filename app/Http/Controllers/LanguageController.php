<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class LanguageController extends Controller
{
    // public function switch($locale, Request $request)
    // {
    //     // Langues autorisées
    //     $availableLocales = ['en', 'fr', 'es'];

    //     if (in_array($locale, $availableLocales)) {
    //         // On stocke la langue en session
    //         session(['locale' => $locale]);
    //     }

    //     // Optionnel : appliquer tout de suite pour cette requête
    //     App::setLocale(session('locale', config('app.locale')));

    //     // On retourne sur la page précédente
    //     return redirect()->back();
    // }

    public function switch($locale, Request $request)
    {
        
        if(in_array($locale,['fr','en','es'])){
            return redirect()->back()->withCookie(cookie('app_locale', $locale, 60 * 24 * 30));
        }
        // On revient sur la page d'avant
        return redirect()->back();
    }
}
