<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Divinite;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\UserPreference;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserPreferenceController extends Controller
{
        public function showQuestionnaire()
        {
            $user = Auth::user();
            // if (method_exists($user, 'hasCompletedQuestionnaire') && $user->hasCompletedQuestionnaire()) {
            //     return redirect()->route('hoost.home');
            // }

            $divinites = Divinite::latest()->get();
            return view('preferences.questionnaire', compact('divinites'));
        }

        public function storePreferences(Request $request)
        {
            
              $data = $request->validate([
              'divinites' => 'array',
              'divinites.*' => 'string',
              'assister_rituel' => 'nullable|boolean',
              ]);

              UserPreference::updateOrCreate(
                ['user_id' => Auth::id()],
                [
                    'divinites_preferees' => $data['divinites'] ?? [],
                    'assister_rituel' => $data['assister_rituel'] ?? false,
                ]
            );

            return redirect()->route('hoost.recommendations')->with('success', 'Vos préférences ont été enregistrées avec succès !');
        }

        public function edit()
        {
            $user = Auth::user();
            $preferences = $user->preferences;
            $divinites = Divinite::latest()->get();
            $selected  = $preferences?->divinites_preferees ?? [];          // tableau d'IDs de divinités
            $wantLive  = $preferences?->assister_rituel ?? null;
            return view('preferences.edit', compact('divinites', 'selected', 'wantLive', 'user'));
        }

        public function update(Request $request)
        {
            $data = $request->validate([
              'divinites' => 'array',
              'divinites.*' => 'string',
              'assister_rituel' => 'nullable|boolean',
              ]);
            Auth::user()->preferences()->update([
                'divinites_preferees' => $data['divinites'] ?? [],
                'assister_rituel' => $data['assister_rituel'] ?? false,
            ]);
            return redirect()->route('hoost.recommendations')->with('success', 'Vos préférences ont été mises à jour avec succès !');
        }
    
    // public function showQuestionnaire()
    // {
    //     $user = Auth::user();

    //     if (method_exists($user, 'hasCompletedQuestionnaire') && $user->hasCompletedQuestionnaire()) {
    //         return redirect()->route('hoost.home');
    //     }

    //     $divinites = Divinite::latest()->get();
    //     return view('preferences.questionnaire', compact('divinites'));
    // }

    // public function storePreferences(Request $request)
    // {
    //     // Validation
    //     $validated = $request->validate([
    //         'divinites_preferees'       => 'required|array|min:1',
    //         'divinites_preferees.*'     => 'exists:divinites,id',
    //         'assister_rituel'           => 'required|in:0,1',
    //         'niveau_immersion'          => 'required',
    //         'preferences_supplementaires' => 'nullable|string',
    //     ]);

    //     $user = Auth::user();

    //     DB::transaction(function () use ($user, $validated) {
    //         $data = [
    //             'divinites_preferees'       => array_map('intval', $validated['divinites_preferees']),
    //             'assister_rituel'           => $validated['assister_rituel'] === '1' ? DB::raw('TRUE') : DB::raw('FALSE'),
    //             'niveau_immersion'          => $validated['niveau_immersion'],
    //             'preferences_supplementaires' => $validated['preferences_supplementaires'] ?? null,
    //         ];

    //         if ($user->preferences) {
    //             $user->preferences->update($data);
    //         } else {
    //             $user->preferences()->create($data);
    //         }

    //         // (ex) notifier l'utilisateur (optionnel, selon ton modèle Notification)
    //         $user->notifications()->create([
    //             'type'    => 'preferences',
    //             'title'   => 'Préférences enregistrées',
    //             'message' => 'Merci d’avoir complété notre questionnaire. Voici nos recommandations pour vous.',
    //             'data'    => ['url' => route('hoost.recommendations')],
    //         ]);
    //     });

    //     return redirect()->route('hoost.recommendations')
    //         ->with('success', 'Vos préférences ont été enregistrées avec succès !');
    // }

    // public function edit()
    // {
    //     $user = Auth::user();
    //     $divinites = Divinite::latest()->get();
    //     $preferences = $user->preferences;

    //     return view('preferences.edit', compact('divinites', 'preferences'));
    // }

    // public function update(Request $request)
    // {
    //     $validated = $request->validate([
    //         'divinites_preferees'         => 'required|array|min:1',
    //         'divinites_preferees.*'       => 'exists:divinites,id',
    //         'assister_rituel'             => 'required|in:0,1',
    //         'niveau_immersion'            => 'required',
    //         'preferences_supplementaires' => 'nullable|string',
    //     ]);

    //     $user = Auth::user();

    //     $user->preferences()->update([
    //         'divinites_preferees'         => array_map('intval', $validated['divinites_preferees']),
    //         'assister_rituel'             => $validated['assister_rituel'] === '1' ? DB::raw('TRUE') : DB::raw('FALSE'),
    //         'niveau_immersion'            => $validated['niveau_immersion'],
    //         'preferences_supplementaires' => $validated['preferences_supplementaires'] ?? null,
    //     ]);

    //     return redirect()->route('hoost.recommendations')
    //         ->with('success', 'Vos préférences ont été mises à jour avec succès !');
    // }
}
