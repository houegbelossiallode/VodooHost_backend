<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class SupabaseAuthController extends Controller
{
    protected string $supabaseUrl;
    protected string $supabaseAnonKey;

    public function __construct()
    {
        $this->supabaseUrl = config('services.supabase.url');
        $this->supabaseAnonKey = config('services.supabase.anon_key');
    }


    public function redirect(string $provider, Request $request)
    {
        $roleSlug = $request->query('slug', 'visiteur');
        session(['social_slug' => $roleSlug]);

        $redirectTo = route('hoost.supabase.callback');

        // Ajout de response_type=token pour forcer le retour par Hash (#access_token=...)
        $url = $this->supabaseUrl
            . '/auth/v1/authorize'
            . '?provider=' . $provider
            . '&redirect_to=' . urlencode($redirectTo)
            . '&response_type=token';

        return redirect()->away($url);
    }

    // public function redirect(string $provider,Request $request)
    // {
    //     // On récupère le rôle choisi dans l’URL
    //     $roleSlug = $request->query('slug'); // défaut : visiteur
    //     // On le stocke en session pour l’utiliser après le retour de Supabase
    //     session(['social_slug' => $roleSlug]);
    //     // URL de redirection OAuth côté Supabase
    //     $redirectTo = route('hoost.supabase.callback');

    //     \Log::info('OAuth Redirect', [
    //         'provider' => $provider,
    //         'role_slug' => $roleSlug,
    //         'redirect_to' => $redirectTo,
    //         'supabase_url' => $this->supabaseUrl,
    //     ]);

    //     $url = $this->supabaseUrl
    //     . '/auth/v1/authorize'
    //     . '?provider=' . $provider
    //     . '&redirect_to=' . urlencode($redirectTo);

    //     \Log::info('OAuth Redirect URL', ['url' => $url]);

    //     return redirect()->away($url);
    // }

    public function callback(Request $request)
    {
        \Log::info('OAuth Callback received', [
            'query_params' => $request->query(),
            'url' => $request->fullUrl(),
        ]);

        return view('auth.supabase-callback');
    }



    public function handle(Request $request)
    {
        $accessToken  = $request->input('access_token');
        $refreshToken = $request->input('refresh_token');
        $roleSlug     = $request->input('role_slug', session('social_slug', 'visitor'));

        if (!$accessToken) {
            return response()->json([
                'success' => false,
                'message' => 'Token Supabase manquant.',
            ], 400);
        }

        // 1) Récupérer le profil utilisateur depuis Supabase
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'apikey'        => $this->supabaseAnonKey, // très important
        ])->get($this->supabaseUrl . '/auth/v1/user');

        if ($response->failed()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération du profil Supabase.',
                'status'  => $response->status(),
                'body'    => $response->body(),
            ], 500);
        }

        $supabaseUser = $response->json();

        $email = $supabaseUser['email'] ?? null;
        $fullName = $supabaseUser['user_metadata']['full_name']
            ?? $supabaseUser['user_metadata']['name']
            ?? null;

        if (!$email) {
            return response()->json([
                'success' => false,
                'message' => "Email non disponible depuis Supabase.",
            ], 400);
        }

        // Rôle choisi (priorité à la requête, sinon session)
        $roleSlug = $roleSlug ?: session('social_slug', 'visitor');

        // On mappe vers les libellés de ta table roles (hote / visiteur)
        $mapSlugToLibelle = [
            'host'     => 'Hote',
            'visitor' => 'Visiteur',
        ];
        $libelleRole = $mapSlugToLibelle[$roleSlug];
        // On récupère l'id du rôle correspondant
        $roleId = Role::where('libelle', $libelleRole)->value('id');
        // 2) Créer / retrouver l'utilisateur Laravel
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'nom'        => $fullName ?? 'Utilisateur Supabase',
                'prenom'     => $fullName,
                'telephone'  => '63521478',
                'profession' => 'Compte social',
                'supabase_id' => $supabaseUser['id'],
                'role_id'=> $roleId
            ]
        );
        // On nettoie la session pour la prochaine fois
        session()->forget('social_slug');
        // 3) Connexion Laravel
        Auth::login($user, true);
        // 4) Optionnel : stocker les tokens en session
        session([
            'supabase_access_token'  => $accessToken,
            'supabase_refresh_token' => $refreshToken,
        ]);
        // Vérifier si l'utilisateur a déjà ses préférences (divinités choisies)
        if ($user->preferences && !empty($user->preferences->divinites_preferees)) {
            return response()->json([
                'success'  => true,
                'message'  => 'Connexion réussie ! Bienvenue ' . $user->nom . ' !',
                'redirect' => url('/hoost/home'),
            ]);
        } else {
            return response()->json([
                'success'  => true,
                'message'  => 'Bienvenue ' . $user->nom . ' ! Veuillez compléter votre questionnaire de préférences.',
                'redirect' => route('hoost.preferences.questionnaire'),
            ]);
        }
    }






}
