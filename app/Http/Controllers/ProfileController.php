<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $preferences = Auth::user()->notificationPreferences;
        return view('profile.index',compact('user', 'preferences'));
    }

    private function uploadImage(\Illuminate\Http\UploadedFile $file): string
    {
        $bucket = env('SUPABASE_BUCKET_PROFILS', 'profils');
        $ext    = strtolower($file->getClientOriginalExtension() ?: 'png');
        $name   = 'profile_'.Str::uuid().'.'.$ext;
        $path   = 'users/'.Auth::id().'/'.$name;

        $resp = Http::withHeaders($this->supaHeaders())
            ->attach('file', file_get_contents($file->getRealPath()), $name)
            ->post($this->supabaseBase()."/object/$bucket/$path");

        if (!$resp->successful()) {
            throw new \RuntimeException('Upload Supabase échoué: '.$resp->body());
        }

        return rtrim(env('SUPABASE_URL'), '/')."/storage/v1/object/public/$bucket/$path";
    }

    private function deleteImage(string $storedValue): void
    {
        $bucket = env('SUPABASE_BUCKET_PROFILS', 'profils');
        $path = $storedValue;
        $needle = "/$bucket/";

        if (str_contains($storedValue, $needle)) {
            $path = substr($storedValue, strpos($storedValue, $needle) + strlen($needle));
        }

        if (!$path) return;
        Http::withHeaders($this->supaHeaders())->delete($this->supabaseBase()."/object/$bucket/$path");
    }

    private function supabaseBase(): string
    {
        return rtrim(env('SUPABASE_URL'), '/').'/storage/v1';
    }

    private function supaHeaders(): array
    {
        return [
            'Authorization' => 'Bearer '.env('SUPABASE_SERVICE_ROLE_KEY'),
            'apikey'        => env('SUPABASE_SERVICE_ROLE_KEY'),
        ];
    }

    public function update(Request $request)
    {
        try{
            /** @var User $user */
        $user = Auth::user();
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            //'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'telephone' => ['required', 'string', 'max:20'],
            'profession' => ['required', 'string', 'max:100'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:4096'],
            'langues' => ['nullable', 'array'],
            'langues.*' => ['string', 'max:50'],
            'passions' => ['nullable', 'array'],
            'passions.*' => ['string', 'max:100'],
            'bio' => ['nullable', 'string'],
            'preferred_currency' => 'nullable',
            ],[
            'photo.image' => 'Le fichier doit être une image valide.',
            'photo.mimes' => 'Le fichier doit être de type :jpeg, :png, :jpg.',
            'photo.max' => 'Le fichier ne doit pas dépasser 4 Mo.',
            'langue.required' => 'Veuillez sélectionner au moins une langue.',
            ]);

        // Photo
        if ($request->hasFile('photo')) {
            if ($user->photo) {
                $this->deleteImage($user->photo);
            }
            $user->photo = $this->uploadImage($request->file('photo'));
        }

                 

        $passions = collect($validated['passions'] ?? [])->map(fn($v)=>trim($v))->filter()->values()->all();
        // Assignations explicites
        $user->nom        = $validated['nom'];
        $user->prenom     = $validated['prenom'];
        //$user->email      = $validated['email'];
        $user->telephone  = $validated['telephone'];
        $user->profession = $validated['profession'];
        $user->bio        = $validated['bio'];
        $user->langue     = $validated['langues'] ?? [];
        $user->passions   = $passions;
        //$user->preferred_currency = $validated['preferred_currency'];
        $user->save();
        //dd($validated['preferred_currency']);
        // $user->preferences()->updateOrCreate(
        //     [],
        //     ['preferred_currency' => $validated['preferred_currency']]
        // );
        // session(['currency' => $validated['preferred_currency']]);

        return redirect()->back()->with('success','Profil mis à jour avec succès!');
        }catch(Exception $e){
            return redirect()->route('hoost.profile.index')->with(['error' => 'Une erreur inattendue s\'est produite : ' . $e->getMessage()]);
        }
        

        // Gestion de la photo
        // if ($request->hasFile('photo')) {
        //     // Supprimer l'ancienne photo si elle existe
        //     if ($user->photo) {
        //         $this->deleteImage($user->photo);
        //     }
        //     // Uploader la nouvelle photo
        //     $validated['photo'] = $this->uploadImage($request->file('photo'));
        // }
        // $langues = [];
        // if (isset($validated['langue']) && is_array($validated['langue'])) {
        //     $langues = array_values(array_filter(array_map('trim', $validated['langue']), function($item) {
        //         return !empty($item);
        //     }));
        // }
        // // S'assurer qu'il y a au moins une langue
        // if (empty($langues)) {
        //     $langues = ['Français']; // Valeur par défaut
        // }
        // // Nettoyer et formater les passions
        // $passions = [];
        // if (isset($validated['passions']) && is_array($validated['passions'])) {
        //     $passions = array_values(array_filter(array_map('trim', $validated['passions']), function($item) {
        //         return !empty($item);
        //     }));
        // }
        // // Mettre à jour les données validées
        // $validated['langue'] = $langues;
        // $validated['passions'] = $passions;
        // $user->update($validated);
        // return redirect()->route('hoost.profile.update')
        //     ->with('success', 'Profil mis à jour avec succès!');
    }


    public function updatePhoto(Request $request)
    {

        // Validation manuelle pour pouvoir renvoyer les erreurs proprement
        $validator = Validator::make($request->all(), [
            'photo' => 'required|image|mimes:jpeg,png,jpg,JPG|max:4096',
        ], [
            'photo.required' => 'La photo est obligatoire.',
            'photo.image' => 'Le fichier doit être une image.',
            'photo.mimes' => 'La photo doit être au format jpeg, jpg ou png.',
            'photo.max' => 'La photo ne doit pas dépasser 4 Mo.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        /** @var User $user */
        $user = Auth::user();

        // Supprimer l'ancienne photo si elle existe
        if ($user->photo) {
            $this->deleteImage($user->photo);
        }

        // Uploader la nouvelle photo
        $photoUrl = $this->uploadImage($request->file('photo'));

        // Mettre à jour le profil
        $user->update(['photo' => $photoUrl]);

        //return redirect()->route('hoost.profile.index')->with('success','photo de profile mis à jour');

        return response()->json([
            'success' => true,
            'photo_url' => $photoUrl
        ]);
    }

}
