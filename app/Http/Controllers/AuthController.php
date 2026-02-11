<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Exception;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{

    protected string $supabaseUrl;
    protected string $supabaseAnonKey;

    public function __construct()
    {
        $this->supabaseUrl    = config('services.supabase.url');
        $this->supabaseAnonKey = config('services.supabase.anon_key');
    }

    public function loginForm()
    {
        return view('auth.login');
    }


    public function store(Request $request)
    {
        try {
            // 1) Validation
            $request->validate([
                'nom'        => 'required',
                'prenom'     => 'required',
                'telephone'  => 'required',
                'profession' => 'required',
                'email'      => 'required|email|unique:users,email',
                'password'   => 'required|min:8|confirmed',
                'slug'       => ['required', 'in:host,visitor'],
            ], [
                'nom.required'        => "Le champs est requis",
                'prenom.required'     => "Le champs est requis",
                'email.required'      => "Le champs est requis",
                'email.unique'        => "L'email est déjà utilisé",
                'email.email'         => "Email invalide",
                'telephone.required'  => "Le champs est requis",
                'profession.required' => "Le champs est requis",
            ]);

            //2) Mapping slug -> libelle en base
            $map = [
                'host'    => 'Hote',
                'visitor' => 'Visiteur',
            ];
            $libelleRole = $map[$request->slug];

            // 3) Récupérer le rôle correspondant
            $role = Role::where('actif', 'OUI')->where('libelle', $libelleRole)->firstOrFail();

            // 5) Créer l'utilisateur dans Supabase Auth
            $supabaseResponse = Http::withHeaders([
                'apikey'       => $this->supabaseAnonKey,
                'Authorization' => 'Bearer ' . $this->supabaseAnonKey,
                'Content-Type' => 'application/json',
            ])
                ->post($this->supabaseUrl . '/auth/v1/signup', [
                    'email'    => $request->email,
                    'password' => $request->password,
                    'data'     => [
                        'nom'        => $request->nom,
                        'prenom'     => $request->prenom,
                        'telephone'  => $request->telephone,
                        'profession' => $request->profession,
                        'slug'       => $request->slug,
                    ],
                ]);

            if ($supabaseResponse->failed()) {
                // Ici c'est vraiment une erreur HTTP (400, 401, 500, etc.)
                return back()->with('error', "Email invalide");
            }

            //Ici, on a une réponse 2xx, on inspecte le JSON
            $payload = $supabaseResponse->json();

            $supabaseUser = $payload['user'] ?? $payload;

            if (! $supabaseUser || empty($supabaseUser['id'])) {
                return back()->with('error', "Réponse inattendue de Supabase lors de la création du compte.");
            }

            // 6) Créer l'utilisateur Eloquent localement
            $user = User::create([
                'supabase_id' => $supabaseUser['id'],   // <--- important : lien avec Supabase
                'nom'         => $request->nom,
                'prenom'      => $request->prenom,
                'telephone'   => $request->telephone,
                'profession'  => $request->profession,
                'email'       => $request->email,
                'role_id'     => $role->id,
            ]);
            return redirect()->route('hoost.accueil')->with('success', "Compte créé. Un email de confirmation vous a été envoyé. Merci de cliquer sur le lien avant de vous connecter.");
        } catch (Exception $e) {
            return redirect()->route('hoost.accueil')->with(['error' => "Une erreur inattendue s'est produite : " . $e->getMessage()]);
        }
    }

    public function login(Request $request)
    {
        // 1) Validation des identifiants
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => 'required',
        ], [
            'email.required'    => "L'email est requis",
            'email.email'       => "Email invalide",
            'password.required' => "Le mot de passe est requis",
        ]);

        try {
            // 2) Appel à Supabase pour vérifier email + mot de passe
            $response = Http::withHeaders([
                'apikey'        => $this->supabaseAnonKey,
                'Authorization' => 'Bearer ' . $this->supabaseAnonKey,
                'Content-Type'  => 'application/json',
            ])
                ->post($this->supabaseUrl . '/auth/v1/token?grant_type=password', [
                    'email'    => $credentials['email'],
                    'password' => $credentials['password'],
                ]);

            if ($response->failed()) {
                // Mauvais email/mot de passe ou autre erreur côté Supabase
                return back()->with("error", "Identifiants incorrects");
            }

            // if ($response->failed()) {
            //     dd([
            //         'status' => $response->status(),
            //         'body'   => $response->body(),
            //         'json'   => $response->json(),
            //     ]);
            // }


            $data        = $response->json();
            $accessToken = $data['access_token'] ?? null;
            $supabaseUser = $data['user'] ?? null;

            if (!$accessToken) {
                return back()->with("error", "Une erreur est survenue");
            }

            // 3) Si besoin, récupérer les infos utilisateur plus complètes
            if (! $supabaseUser) {
                $userResponse = Http::withHeaders([
                    'apikey'        => $this->supabaseAnonKey,
                    'Authorization' => 'Bearer ' . $accessToken,
                ])
                    ->get($this->supabaseUrl . '/auth/v1/user');

                if ($userResponse->failed()) {
                    return back()->with("error", "Impossible de récupérer le profil utilisateur.");
                }

                $supabaseUser = $userResponse->json();
            }

            $supabaseId = $supabaseUser['id'] ?? null;
            $email      = $supabaseUser['email'] ?? $credentials['email'];
            // 4) Synchroniser / récupérer le User Eloquent local
            $user = User::where('actif', 'OUI')->where('supabase_id', $supabaseId)
                ->orWhere('email', $email)
                ->first();
            if (!$user) {
                return back()->with("error", "Compte non synchronisé. Contactez le support.");
            }

            Auth::login($user);
            // 6) Redirection vers la page d'accueil (ou intended)
            // Vérifier si l'utilisateur a déjà répondu au questionnaire
            if ($user->preferences && !empty($user->preferences->divinites_preferees)) {
                return redirect()->intended('/hoost/home')->with('success', 'Connexion réussie ! Bienvenue ' . $user->nom . ' !');
            } else {
                return redirect()->route('hoost.preferences.questionnaire')
                    ->with('info', 'Bienvenue ' . $user->nom . ' ! Pour personnaliser votre expérience, veuillez répondre à ce court questionnaire.');
            }
        } catch (Exception $e) {
            return back()->with("email", "Une erreur inattendue s'est produite : " . $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/hoost')->with('success', 'Déconnexion réussie ! À bientôt !');
    }


    public function forgotForm()
    {
        return view('auth.forgot-password');
    }
    /**
     * Envoi du lien de réinitialisation de mot de passe
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);
        try {
            $response = Http::withHeaders([
                'apikey' => $this->supabaseAnonKey,
                'Content-Type' => 'application/json',
            ])->post($this->supabaseUrl . '/auth/v1/recover', [
                'email' => $request->email,
                'redirect_to' => url('/hoost/reset-password'),
            ]);
            if ($response->successful()) {
                return back()->with('success', 'Un email de réinitialisation a été envoyé à votre adresse email.');
            }
            return back()->with('error', 'Impossible d\'envoyer l\'email de réinitialisation. Vérifiez votre adresse email.');
        } catch (Exception $e) {
            return back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }
    /**
     * Affiche le formulaire de réinitialisation
     */
    public function showResetForm(Request $request)
    {
        if (!$request->has('access_token')) {
            return view('auth.reset-token-capture');
        }


        $token = $request->query('access_token');
        $type = $request->query('type');

        //dd($token, $type);
        if (!$token || $type !== 'recovery') {
            return redirect()->route('login')
                ->with('error', 'Lien de réinitialisation invalide ou expiré.');
        }
        // Vérifier si le token est valide
        $response = Http::withHeaders([
            'apikey' => $this->supabaseAnonKey,
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->supabaseUrl . '/auth/v1/user');
        if ($response->failed()) {
            return redirect()->route('login')
                ->with('error', 'Lien de réinitialisation invalide ou expiré.');
        }
        $userData = $response->json();
        $email = $userData['email'] ?? null;
        if (!$email) {
            return redirect()->route('login')
                ->with('error', 'Impossible de récupérer l\'email associé à ce lien.');
        }
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $email
        ]);
    }


    /**
     * Traite la réinitialisation du mot de passe
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);
        try {
            // Vérifier d'abord si le token est valide
            $response = Http::withHeaders([
                'apikey' => $this->supabaseAnonKey,
                'Authorization' => 'Bearer ' . $request->token,
            ])->get($this->supabaseUrl . '/auth/v1/user');
            if ($response->failed()) {
                return back()->with('error', 'Le lien de réinitialisation est invalide ou a expiré.');
            }
            // Mettre à jour le mot de passe
            $updateResponse = Http::withHeaders([
                'apikey' => $this->supabaseAnonKey,
                'Authorization' => 'Bearer ' . $request->token,
                'Content-Type' => 'application/json',
            ])->put($this->supabaseUrl . '/auth/v1/user', [
                'password' => $request->password
            ]);
            if ($updateResponse->successful()) {
                // Mettre à jour également le mot de passe dans la base de données locale si nécessaire
                $user = User::where('email', $request->email)->first();
                if ($user) {
                    $user->password = Hash::make($request->password);
                    $user->save();
                }

                return redirect()->route('hoost.login')->with('success', 'Votre mot de passe a été réinitialisé avec succès. Vous pouvez maintenant vous connecter.');
            }
            return back()->with('error', 'Impossible de réinitialiser le mot de passe. Veuillez réessayer.');
        } catch (Exception $e) {
            return back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }


    // public function forgotForm()
    // {
    //     return view('auth.forgot-password');
    // }

    // /**
    //  * Envoi du lien de réinitialisation de mot de passe
    //  */
    // public function sendResetLink(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email'
    //     ]);

    //     $response = Http::withHeaders([
    //         'apikey' => $this->supabaseAnonKey,
    //         'Content-Type' => 'application/json',
    //     ])->post($this->supabaseUrl.'/auth/v1/recover', [
    //         'email' => $request->email,
    //         'redirect_to' => url('/reset-password'),
    //     ]);

    //     if ($response->successful()) {
    //         return back()->with('success', 'Email envoyé avec succès.');
    //     }

    //     return back()->with('error', 'Une erreur est survenue.');
    // }

    //  /**
    //  * Affichage du formulaire (après clic dans l’email)
    //  */
    // public function showResetForm(Request $request)
    // {
    //     return view('auth.reset-password', [
    //         'access_token' => $request->access_token
    //     ]);
    // }

    // /**
    //  * Mise à jour du mot de passe avec le token Supabase
    //  */
    // public function resetPassword(Request $request)
    // {
    //     try{
    //       $request->validate([
    //         'password' => 'required|confirmed|min:6',
    //         'access_token' => 'required'
    //     ]);

    //     $response = Http::withHeaders([
    //         'apikey' => $this->supabaseAnonKey,
    //         'Authorization' => 'Bearer '.$request->access_token,
    //         'Content-Type' => 'application/json',
    //     ])->put($this->supabaseUrl.'/auth/v1/user', [
    //         'password' => $request->password
    //     ]);

    //     //dd($response->json());

    //     if ($response->successful()) {
    //         return redirect('/login')->with('success', 'Mot de passe mis à jour.');
    //     }
    //     //return back()->with('error', 'Impossible de mettre à jour le mot de passe.');
    //     }
    //     catch(Exception $e){
    //         return redirect()->route('hoost.accueil')->with('error', 'Une erreur est survenue : ' . $e->getMessage());
    //     }
    // }





}
