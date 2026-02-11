<?php

namespace App\Http\Controllers;

use App\Http\Requests\RituelRequest;
use App\Models\Rituel;
use Illuminate\Http\Request;
use Supabase\Storage\StorageClient;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class RituelController extends Controller
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

    private function uploadSymbole(\Illuminate\Http\UploadedFile $file): string
    {
        $bucket = env('SUPABASE_STORAGE_BUCKET', 'rituels');
        $ext    = strtolower($file->getClientOriginalExtension() ?: 'png');
        $name   = 'symbole_'.Str::uuid().'.'.$ext;
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

    private function deleteSymbole(string $storedValue): void
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


    public function index()
    {
        $rituels = Rituel::orderBy('updated_at','desc')->paginate(10)->withQueryString();
        return view('rituels.index', compact('rituels'));
    }

    public function create()
    {
      
        return view('rituels.create');
    }

    public function store(RituelRequest $request)
    {
        //dd($request->all());
        $data = $request->validated();

        //Upload image si fournie
        if ($request->hasFile('symbole')) {
            $data['symbole'] = $this->uploadSymbole($request->file('symbole'));
        }
       
        Rituel::create($data);
        //Rituel::create($request->validated());
        return redirect()->route('hoost.rituels.index')->with('success', 'Rituel créé avec succès.');
    }

    

    public function edit(Rituel $rituel)
    {
        return view('rituels.edit', compact('rituel'));
    }

    public function update(RituelRequest $request, Rituel $rituel)
    {
        $data = $request->validated();
        if ($request->hasFile('symbole')) {
            if (!empty($rituel->symbole)) {
                $this->deleteSymbole($rituel->symbole);
            }
            $data['symbole'] = $this->uploadSymbole($request->file('symbole'));
        }
        $rituel->update($data);
        return redirect()->route('hoost.rituels.index')->with('success', 'Rituel mis à jour.');
    }

    public function destroy(Rituel $rituel)
    {
        //Nettoyage côté Storage
        if (!empty($rituel->symbole)) {
            $this->deleteSymbole($rituel->symbole);
        }

        $rituel->delete();

        return redirect()->route('hoost.rituels.index')->with('success', 'Rituel supprimé.');
    }
}
