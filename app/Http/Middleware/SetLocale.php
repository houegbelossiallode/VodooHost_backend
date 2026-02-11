<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Vérifier si la langue est dans la session
        // if ($request->session()->has('locale')) {
        //     $locale = $request->session()->get('locale');
        // }
        // // 2. Sinon, vérifier si elle est dans l'URL
        // elseif ($request->has('lang') && in_array($request->lang, ['en', 'fr', 'es'])) {
        //     $locale = $request->lang;
        //     session(['locale' => $locale]);
        // }
        // // 3. Sinon, utiliser la langue du navigateur si supportée
        // elseif ($request->hasHeader('Accept-Language')) {
        //     $browserLocale = substr($request->header('Accept-Language'), 0, 2);
        //     $locale = in_array($browserLocale, ['en', 'fr', 'es']) ? $browserLocale : config('app.locale');
        // }
        // // 4. Sinon, utiliser la langue par défaut de l'application
        // else {
        //     $locale = config('app.locale');
        // }

        // // Définir la locale pour l'application
        // App::setLocale($locale);

        // // Partager la locale avec toutes les vues
        // view()->share('current_locale', $locale);

        $locale = $request->cookie('app_locale',config('app.locale'));

        App::setLocale($locale);
        return $next($request);
    }
}
