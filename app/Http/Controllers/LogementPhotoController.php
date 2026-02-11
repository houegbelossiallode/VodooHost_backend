<?php

namespace App\Http\Controllers;

use App\Models\Logement;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LogementPhotoController extends Controller
{
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

    private function deleteFromSupabase(string $storedUrl): void
    {
        $bucket = env('SUPABASE_BUCKET_LOGEMENTS', 'logements');

        // Extraire le chemin réel depuis l’URL publique
        $needle = "/$bucket/";
        $path = $storedUrl;
        if (str_contains($storedUrl, $needle)) {
            $path = substr($storedUrl, strpos($storedUrl, $needle) + strlen($needle));
        }

        if (!$path) return;

        $resp = Http::withHeaders($this->supaHeaders())
            ->delete($this->supabaseBase()."/object/$bucket/$path");

        if (!$resp->successful()) {
            \Log::warning('Erreur Supabase delete: '.$resp->body());
        }
    }

    /**
     * Supprime une photo du logement.
     */
    public function destroy(Logement $logement, Photo $photo,Request $request)
    {
        // Vérification sécurité
        if ($photo->logement_id !== $logement->id) {
            abort(403, 'Cette photo ne correspond pas à ce logement.');
        }

        // Suppression du fichier côté Supabase
        if (!empty($photo->url)) {
            $this->deleteFromSupabase($photo->url);
        }

        // Suppression DB
        $photo->delete();
        // Si la requête vient d'AJAX → JSON
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()
            ->route('hoost.logements.edit', $logement)
            ->with('success', 'Photo supprimée avec succès.');
    }

    /**
     * Ajoute de nouvelles photos (si tu veux gérer l’upload séparé).
     */
    public function store(Request $request, Logement $logement)
    {
        $request->validate([
            'photos'   => ['required','array','max:20'],
            'photos.*' => ['file','image','mimes:jpg,jpeg,png,webp','max:5120'],
        ]);

        foreach ($request->file('photos') as $file) {
            $url = $this->uploadPhotoToSupabase($file, $logement->id);
            \App\Models\Photo::create([
                'logement_id' => $logement->id,
                'url'         => $url,
            ]);
        }

        return redirect()->route('hoost.logements.edit', $logement)->with('success', 'Photos ajoutées avec succès.');
    }

    private function uploadPhotoToSupabase(\Illuminate\Http\UploadedFile $file, int $logementId): string
    {
        $bucket = env('SUPABASE_BUCKET_LOGEMENTS', 'logements');
        $ext    = strtolower($file->getClientOriginalExtension() ?: 'jpg');
        $name   = uniqid('photo_').'.'.$ext;
        $path   = "logements/{$logementId}/".date('Y/m/').$name;

        $resp = Http::withHeaders($this->supaHeaders())
            ->attach('file', file_get_contents($file->getRealPath()), $name)
            ->post($this->supabaseBase()."/object/$bucket/$path");

        if (!$resp->successful()) {
            throw new \RuntimeException('Upload Supabase échoué: '.$resp->body());
        }

        return rtrim(env('SUPABASE_URL'), '/')."/storage/v1/object/public/$bucket/$path";
    }
}
