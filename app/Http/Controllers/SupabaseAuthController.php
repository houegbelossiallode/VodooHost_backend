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

        // Utiliser l'URL de callback par défaut de Supabase
        // Supabase redirigera ensuite vers votre application via le dashboard
        $redirectTo = route('hoost.supabase.callback');

        $url = $this->supabaseUrl
            . '/auth/v1/authorize'
            . '?provider=' . $provider
            . '&redirect_to=' . urlencode($redirectTo);

        Log::info('OAuth Redirect URL', ['url' => $url]);

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
        Log::info('OAuth Callback received', [
            'query_params' => $request->query(),
            'url' => $request->fullUrl(),
        ]);

        return view('auth.supabase-callback');
    }



    public function handle(Request $request)
    {
        $accessToken  = $request->input('access_token');
        $refreshToken = $request->input('refresh_token');

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

        if (!$email) {
            return response()->json([
                'success' => false,
                'message' => "Email non disponible depuis Supabase.",
            ], 400);
        }

        $user = User::where('supabase_id', $supabaseUser['id'])
            ->orWhere('email', $email)
            ->first();

        if ($user && $user->supabase_id && $user->supabase_id !== $supabaseUser['id']) {
            return response()->json([
                'success' => false,
                'message' => 'Cette adresse email est déjà associée à un autre compte.',
            ], 409);
        }

        if (!$user) {
            $roleSlug = $request->input('role_slug');

            if (!$roleSlug) {
                return response()->json([
                    'success' => true,
                    'needs_profile' => true,
                ]);
            }

            $roleLabels = [
                'host' => 'Hote',
                'visitor' => 'Visiteur',
                'photographer' => 'Photographe',
                'manager' => 'Manager',
            ];

            if (!array_key_exists($roleSlug, $roleLabels)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Veuillez choisir un profil valide.',
                ], 422);
            }

            $role = Role::where('actif', 'OUI')->where('libelle', $roleLabels[$roleSlug])->first();

            if (!$role) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ce profil est momentanément indisponible.',
                ], 422);
            }

            $metadata = $supabaseUser['user_metadata'] ?? [];
            $firstName = trim((string) ($metadata['given_name'] ?? ''));
            $lastName = trim((string) ($metadata['family_name'] ?? ''));
            $fullName = trim((string) ($metadata['full_name'] ?? $metadata['name'] ?? ''));

            if ($firstName === '' && $fullName !== '') {
                $nameParts = preg_split('/\s+/', $fullName) ?: [];
                $firstName = array_shift($nameParts) ?? '';
                if ($lastName === '') {
                    $lastName = implode(' ', $nameParts);
                }
            }

            $firstName = $firstName !== '' ? $firstName : 'Utilisateur';
            $lastName = $lastName !== '' ? $lastName : $firstName;
            $phone = $metadata['phone'] ?? null;
            $profession = $metadata['profession'] ?? null;

            $user = User::create([
                'supabase_id' => $supabaseUser['id'],
                'nom' => $lastName,
                'prenom' => $firstName,
                'telephone' => is_string($phone) && trim($phone) !== '' ? $phone : '63521478',
                'profession' => is_string($profession) && trim($profession) !== '' ? $profession : 'Compte social',
                'email' => $email,
                'role_id' => $role->id,
                'photo' => $metadata['avatar_url'] ?? $metadata['picture'] ?? null,
            ]);
        } elseif (!$user->supabase_id) {
            $user->supabase_id = $supabaseUser['id'];
            $user->save();
        }

        

        // Connecter uniquement après avoir trouvé ou créé le profil local.
        Auth::login($user, true);
        session([
            'supabase_access_token'  => $accessToken,
            'supabase_refresh_token' => $refreshToken,
        ]);

        if ($user->preferences && !empty($user->preferences->divinites_preferees)) {
            return response()->json([
                'success'  => true,
                'needs_profile' => false,
                'message'  => 'Connexion réussie ! Bienvenue ' . $user->nom . ' !',
                'redirect' => url('/hoost/home'),
            ]);
        } else {
            return response()->json([
                'success'  => true,
                'needs_profile' => false,
                'message'  => 'Bienvenue ' . $user->nom . ' ! Veuillez compléter votre questionnaire de préférences.',
                'redirect' => route('hoost.preferences.questionnaire'),
            ]);
        }
    }






}
