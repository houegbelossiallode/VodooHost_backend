<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SupabaseCallbackController extends Controller
{
    public function handle(Request $request)
    {
        $accessToken = $request->query('access_token') ?? $request->query('token');
        $email = $request->query('email');

        // 1) Si token présent -> rediriger frontend pour auto-login
        if ($accessToken) {
            $url = config('app.frontend_success_with_token') . '?access_token=' . urlencode($accessToken);
            return redirect()->away($url);
        }

        // 2) Sinon vérifier confirmation côté serveur via l'API admin de Supabase
        if (!$email) {
            return response()->view('auth.email_confirmed'); // page simple
        }

        $supabaseUrl = env('SUPABASE_URL');
        $serviceKey = env('SUPABASE_SERVICE_ROLE');

        // Appel à l'API Admin de Supabase : /auth/v1/admin... ou via PostgREST sur auth.users
        // Utiliser l'endpoint admin pour récupérer l'utilisateur (service role)
        $resp = Http::withHeaders([
            'apiKey' => $serviceKey,
            'Authorization' => 'Bearer ' . $serviceKey,
        ])->get("{$supabaseUrl}/auth/v1/admin/users", [
            'email' => $email
        ]);

        if ($resp->failed()) {
            return response('Erreur interne', 500);
        }

        $users = $resp->json();
        // $users peut être un objet ou tableau selon endpoint — adaptez selon résultat
        $confirmedAt = null;
        if (is_array($users) && count($users) > 0) {
            $u = $users[0];
            $confirmedAt = $u['confirmed_at'] ?? ($u['email_confirmed_at'] ?? null);
        } elseif (is_array($users) && isset($users['confirmed_at'])) {
            $confirmedAt = $users['confirmed_at'] ?? ($users['email_confirmed_at'] ?? null);
        }

        if (!$confirmedAt) {
            return view('auth.confirmation_pending', ['email' => $email]);
        }

        // Tout OK : redirection vers frontend (page login)
        return redirect()->away(config('app.frontend_confirm_success'));
    }
}