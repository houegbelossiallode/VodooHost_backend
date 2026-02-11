<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
     /**
     * PAGE D’AIDE (profil → aide)
     */


     public function index(){
        $reports = Report::where('user_id',Auth::id())->orderBy('updated_at','desc')->get();
        return view('reports.index',compact('reports'));
     }
    

    public function help()
    {
        return view('profile.aide');
    }

    /**
     * AFFICHER LE FORMULAIRE “Signaler un problème”
     */
    public function create(Request $request)
    {
        // Permet de pré-remplir l’URL de l’annonce si elle est passée en paramètre
        $annonceUrl = $request->query('annonce');
        return view('reports.create', compact('annonceUrl'));
    }

    public function edit($id)
    {
        $report = Report::where('id',$id)->where('user_id',Auth::id())->first();
        return view('reports.edit', compact('report'));
    }


    public function update(Request $request, $id)
    {
        $report = Report::where('id', $id)
            ->where('user_id',Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'annonce_url' => ['nullable','max:255'],
            'type' => 'nullable',
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ]);

        $report->update($validated);

        return redirect()->route('hoost.reports.index')->with('success', 'Le problème a été mis à jour avec succès.');
    }



    /**
     * TRAITER LA SOUMISSION DU FORMULAIRE
     */
    public function store(Request $request)
    {
        //dd($request);
        try{
          $data = $request->validate([
            'annonce_url' => ['nullable', 'string', 'max:255'],
            'type'        => ['nullable', 'string', 'max:100'],
            'message'     => ['required', 'string', 'min:10'],
        ], [
            'message.required' => 'Merci de décrire le problème.',
            'message.min'      => 'Le message doit contenir au moins 10 caractères.',
        ]);

        // Enregistrement du signalement
        Report::create([
            'user_id'     => Auth::id(),
            'annonce_url' => $data['annonce_url'] ?? null,
            'type'        => $data['type'] ?? null,
            'message'     => $data['message'],
            'status'      => 'nouveau', // statut initial
        ]);

        return redirect()->route('hoost.reports.index')->with('success', 'Votre problème a été signalé. Nous vous répondrons rapidement.');
        }catch(Exception $e){
            return redirect()->route('hoost.reports.index')->with('error', 'Une erreur est survenue' . $e->getMessage());
        }
    }

   public function destroy($id)
    {
        $report = Report::findOrFail($id);
        $report->delete();

        return redirect()->route('hoost.reports.index')->with('success', 'Problème  supprimé avec succès.');
    } 
}
