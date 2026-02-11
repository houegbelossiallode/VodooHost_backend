<?php

namespace App\Http\Controllers;

use App\Mail\Welcome;
use App\Models\Constance;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session as SessionFacade;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{

    protected string $supabaseUrl;
    protected string $supabaseAnonKey;

    public function __construct()
    {
        $this->supabaseUrl    = config('services.supabase.url');
        $this->supabaseAnonKey = config('services.supabase.anon_key');
    }


    public function index()
    {
        $users = User::orderBy('updated_at', 'desc')->get();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::latest()->get();
        return view('users.create', compact('roles'));
    }

    // public function store(Request $request)
    // {
    //     try {

    //         $request->validate([
    //             'nom' => 'required',
    //             "prenom" => "required",
    //             "telephone" => "required",
    //             "profession" => "required",
    //             "email" => "required|email|unique:users,email",
    //             "role_id"    => "nullable|exists:roles,id",
    //             'slug'  => ['required', 'in:host,visitor'],

    //         ], [
    //             'nom.required' => "Le champs est requis",
    //             'prenom.required' => "Le champs est requis",
    //             'email.required' => "Le champs est requis",
    //             'email.unique' => "L'email est déjà utilisé",
    //             'email.email' => "Email invalide",
    //             'telephone.required' => "Le champs est requis",
    //             'profession.required' => "Le champs est requis",

    //         ]);

    //         // 2) Mapping slug -> libelle en base
    //         $map = [
    //             'host'     => 'Hote',
    //             'visitor' => 'Visiteur',
    //         ];
    //         $libelleRole = $map[$request['slug']];
    //         // 3) Récupérer le role correspondant dans la table roles
    //         $role = Role::where('libelle', $libelleRole)->firstOrFail();

    //         $password = $this->generatePassword();
    //         $user = User::create([
    //             'nom' => $request->nom,
    //             'prenom' => $request->prenom,
    //             'telephone' => $request->telephone,
    //             'profession' => $request->profession,
    //             'email' => $request->email,
    //             'password' => Hash::make($password),
    //             'role_id' => $request->role_id ?? $role->id
    //         ]);
    //         // Envoi de l'email de bienvenue avec le mot de passe généré
    //         Mail::to($user->email)->send(new Welcome($user, $password));
    //         // Redirection selon l'état de connexion
    //         if (Auth::check()) {
    //             return redirect()->route('hoost.users.index')->with('success', 'User créé avec succès.');
    //         }
    //         return redirect()->route('hoost.accueil')->with('success', 'Compte creé avec succès.');
    //     } catch (Exception $e) {
    //         if (Auth::check()) {
    //             return redirect()->route('hoost.users.index')->with(['error' => 'Une erreur inattendue s\'est produite : ' . $e->getMessage()]);
    //         }
    //         return redirect()->route('hoost.accueil')->with(['error' => 'Une erreur inattendue s\'est produite : ' . $e->getMessage()]);
    //     }
    // }

    


    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::latest()->get();
        return view('users.edit', compact('roles', 'user'));
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);
            $request->validate([
                'nom' => 'required',
                "prenom" => "required",
                "telephone" => "required",
                "profession" => "required",
                'email'      => [
                    'required',
                    'email',
                    Rule::unique('users', 'email')->ignore($user->id),
                ],
                "role_id"    => "nullable|exists:roles,id",
            ], [
                'nom.required' => "Le champs est requis",
                'prenom.required' => "Le champs est requis",
                'email.required' => "Le champs est requis",
                'email.unique' => "L'email est déjà utilisé",
                'email.email' => "Email invalide",
                'telephone.required' => "Le champs est requis",
                'profession.required' => "Le champs est requis",
            ]);


            $user->update([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'telephone' => $request->telephone,
                'profession' => $request->profession,
                'email' => $request->email,
                'role_id' => $request->role_id
            ]);
            return redirect()->route('hoost.users.index')->with('success', 'User modifié avec succès.');
        } catch (Exception $e) {
            // Gestion des erreurs : redirection avec un message d'erreur
            return redirect()->route('hoost.users.index')->with(['error' => 'Une erreur inattendue s\'est produite : ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        //
    }

    private function generatePassword($length = 8)
    {
        return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
    }


    public function showSettings()
    {
        $user = Auth::user();
        // Récupérer les sessions actives de l'utilisateur
        $sessions = DB::table('sessions')
            ->where('user_id', $user->id)
            ->orderBy('last_activity', 'desc')
            ->get(['id', 'user_agent', 'ip_address', 'last_activity', 'payload'])
            ->map(function ($session) {
                return (object) [
                    'id' => $session->id,
                    'user_agent' => $this->parseUserAgent($session->user_agent),
                    'ip_address' => $session->ip_address,
                    'last_activity' => $session->last_activity,
                    'is_current' => $session->id === SessionFacade::getId(),
                ];
            });
        return view('users.settings', compact('user', 'sessions'));
    }

    public function updateSecurity(Request $request)
    {
        try {
            /** @var User $user */
            $user = Auth::user();

            $request->validate([
                'current_password' => ['required', 'current_password'],
                'password' => ['required', 'confirmed', 'min:8'],
            ], [
                'current_password' => 'Le mot de passe actuelle est obligatoire',
                'password' =>  'Le nouveau mot de passe est obligatoire',
                'password.confirmed' => 'Les deux mots de passe ne correspondent pas'
            ]);

            $user->update([
                'password' => Hash::make($request->password),
            ]);

            return redirect()->back()->with('success', 'Mot de passe mis à jour avec succès');
        } catch (Exception $e) {
            return redirect()->route('hoost.profile.index')->with(['error' => 'Une erreur inattendue s\'est produite : ' . $e->getMessage()]);
        }
    }


    protected function parseUserAgent($userAgent)
    {
        $browser = 'Inconnu';
        $os = 'Inconnu';

        // Détection du navigateur
        if (preg_match('/MSIE/i', $userAgent) && !preg_match('/Opera/i', $userAgent)) {
            $browser = 'Internet Explorer';
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            $browser = 'Mozilla Firefox';
        } elseif (preg_match('/Chrome/i', $userAgent)) {
            $browser = 'Google Chrome';
        } elseif (preg_match('/Safari/i', $userAgent)) {
            $browser = 'Apple Safari';
        } elseif (preg_match('/Opera/i', $userAgent)) {
            $browser = 'Opera';
        } elseif (preg_match('/Netscape/i', $userAgent)) {
            $browser = 'Netscape';
        } elseif (preg_match('/Edge/i', $userAgent)) {
            $browser = 'Microsoft Edge';
        }

        // Détection du système d'exploitation
        if (preg_match('/Windows NT 10.0/i', $userAgent)) {
            $os = 'Windows 10';
        } elseif (preg_match('/Windows NT 6.3/i', $userAgent)) {
            $os = 'Windows 8.1';
        } elseif (preg_match('/Windows NT 6.2/i', $userAgent)) {
            $os = 'Windows 8';
        } elseif (preg_match('/Windows NT 6.1/i', $userAgent)) {
            $os = 'Windows 7';
        } elseif (preg_match('/Windows NT 6.0/i', $userAgent)) {
            $os = 'Windows Vista';
        } elseif (preg_match('/Windows NT 5.1/i', $userAgent)) {
            $os = 'Windows XP';
        } elseif (preg_match('/Macintosh|Mac OS X/i', $userAgent)) {
            $os = 'Mac OS X';
        } elseif (preg_match('/Linux/i', $userAgent)) {
            $os = 'Linux';
        } elseif (preg_match('/Android/i', $userAgent)) {
            $os = 'Android';
        } elseif (preg_match('/iPhone|iPad|iPod/i', $userAgent)) {
            $os = 'iOS';
        }

        return $browser . ' sur ' . $os;
    }
}
