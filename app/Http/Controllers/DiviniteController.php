<?php

namespace App\Http\Controllers;

use App\Models\Divinite;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class DiviniteController extends Controller
{
    public function index()
    {
        $divinites = Divinite::where('actif','OUI')->orderBy('updated_at','desc')->paginate(10)->withQueryString();
        return view('divinites.index', compact('divinites'));
    }

    public function create()
    {
        return view('divinites.create');
    }

    public function store(Request $request)
    {
        try{
        // Logique pour stocker une nouvelle divinité
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:4096',
            ],[
            'nom.required' => 'Le nom est obligatoire.',
            'description.required' => 'La description est obligatoire.',
            'image.required' => "L'image est obligatoire.",
            'image.image' => "Le fichier doit être une image.",
            'image.mimes' => "L'image doit être au format jpeg, png ou jpg.",
            'image.max' => "L'image ne doit pas dépasser 4MB.",
            ]);
        //Uploader l'image avec supabase
        $imagePath = $this->uploadImage($request->file('image'));
        // Sauvegarder la divinité dans la base de données
        $divinite = Divinite::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'image' => $imagePath,
        ]);
        return redirect()->route('hoost.divinites.index')->with('success', 'Divinité créée avec succès.');
        }catch(Exception $e){
          return redirect()->back()->with('error','Une erreur est survenue' . $e->getMessage());
        }
        
    }

    public function show(Divinite $divinite)
    {
        //
    }   

    public function edit(Divinite $divinite)
    {
        return view('divinites.edit', compact('divinite'));
    }


    public function update(Request $request, Divinite $divinite)
    {
        try{
          $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:4096',
        ],[
            'nom.required' => 'Le nom est obligatoire.',
            'description.required' => 'La description est obligatoire.',
            'image.image' => "Le fichier doit être une image.",
            'image.mimes' => "L'image doit être au format jpeg, png ou jpg.",
            'image.max' => "L'image ne doit pas dépasser 4MB.",
        ]);
        //Mettre à jour l'image si fournie
        if ($request->hasFile('image')) {
            //Supprimer l'ancienne image
            $this->deleteImage($divinite->image);
            //Uploader la nouvelle image
            $divinite->image = $this->uploadImage($request->file('image'));
        }
        // Mettre à jour les autres champs
        $divinite->nom = $request->nom;
        $divinite->description = $request->description;
        $divinite->save();
        return redirect()->route('hoost.divinites.index')->with('success', 'Divinité mise à jour avec succès.');
        }catch(Exception $e){
          return redirect()->back()->with('error','Une erreur est survenue' . $e->getMessage());
        }
        
    }

    public function destroy(Divinite $divinite)
    {
        //Supprimer l'image associée
        $this->deleteImage($divinite->image);
        $divinite->delete();
        return redirect()->route('hoost.divinites.index')->with('success', 'Divinité supprimée avec succès.');
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

    private function uploadImage(\Illuminate\Http\UploadedFile $file): string
    {
        $bucket = env('SUPABASE_STORAGE_BUCKET', 'rituels');
        $ext    = strtolower($file->getClientOriginalExtension() ?: 'png');
        $name   = 'image_'.Str::uuid().'.'.$ext;
        $path   = date('Y/m/').$name;

        $resp = Http::withHeaders($this->supaHeaders())
            ->attach('file', file_get_contents($file->getRealPath()), $name)
            ->post($this->supabaseBase()."/object/$bucket/$path", [
                // rien d’autre, le binaire est déjà dans attach()
            ]);

        if (!$resp->successful()) {
            // Option: logger la réponse pour debug
            throw new \RuntimeException('Upload Supabase échoué: '.$resp->body());
        }

        // Si le bucket est public:
        return rtrim(env('SUPABASE_URL'), '/')."/storage/v1/object/public/$bucket/$path";

        // Si bucket privé: retourne plutôt "$path" et génère une URL signée au besoin.
    }

    private function deleteImage(string $storedValue): void
    {
        $bucket = env('SUPABASE_STORAGE_BUCKET', 'rituels');

        // Si on a stocké une URL publique, extraire le chemin réel :
        $path = $storedValue;
        $needle = "/$bucket/";
        if (str_contains($storedValue, $needle)) {
            $path = substr($storedValue, strpos($storedValue, $needle) + strlen($needle));
        }

        if (!$path) return;

        // Suppression d’un objet :
        $resp = Http::withHeaders($this->supaHeaders())
            ->delete($this->supabaseBase()."/object/$bucket/$path");

        // Si besoin, vérifier $resp->successful()
    }
}



