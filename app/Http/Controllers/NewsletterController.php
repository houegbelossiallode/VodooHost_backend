<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewsletterSubscription;
use Illuminate\Support\Facades\Log;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:newsletters,email',
        ]);

        $token = Str::random(32);

        $newsletter = Newsletter::create([
            'email' => $validated['email'],
            'token' => $token,
            'is_active' => true
        ]);

        try {
            // Envoyer un email de confirmation
            Mail::to($validated['email'])->send(new NewsletterSubscription($newsletter));
        } catch (\Exception $e) {
            // Enregistrer l'erreur dans les logs
            Log::error('Erreur lors de l\'envoi de l\'email de confirmation : ' . $e->getMessage());
            
            // Renvoyer une réponse d'erreur
            return response()->json([
                'success' => false,
                'message' => 'Votre inscription a été enregistrée, mais une erreur est survenue lors de l\'envoi de l\'email de confirmation.'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Merci pour votre inscription à notre newsletter !'
        ]);
    }

    public function unsubscribe($token)
    {
        $subscriber = Newsletter::where('token', $token)->firstOrFail();
        $subscriber->update(['is_active' => false]);

        return redirect('/')
            ->with('success', 'Vous avez été désabonné de notre newsletter avec succès.');
    }
}
