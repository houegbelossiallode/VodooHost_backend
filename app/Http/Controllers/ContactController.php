<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use App\Models\Contact;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index(){
        $contacts = Contact::where('actif','OUI')->orderBy('updated_at','desc')->get();
        return view('contacts.index',compact('contacts'));
    }

    public function liste(){
        return view('pages.contact');
    }

    public function store(Request $request)
    {
        // --- VALIDATION (renvoie JSON automatiquement si Accept: application/json) ---
        $validated = $request->validate([
            'nom'     => 'required|string|max:255',
            'prenom'  => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'message' => 'required|string'
        ], [
            'nom.required'     => 'Le nom est requis',
            'prenom.required'  => 'Le prénom est requis',
            'email.required'   => "L'email est requis",
            'email.email'      => "L'email n'est pas valide",
            'message.required' => 'Le message est obligatoire'
        ]);

        // --- ENREGISTREMENT EN BASE ---
        $contact = Contact::create([
            'nom'     => $validated['nom'],
            'prenom'  => $validated['prenom'],
            'email'   => $validated['email'],
            'message' => $validated['message']
        ]);

        // --- ENVOI DE L'EMAIL ---
        try {
            Mail::to($validated['email'])->send(new ContactFormMail($contact));
            // --- RÉPONSE JSON AU SUCCÈS ---
            return response()->json([
                'success' => true,
                'message' => 'Votre message a été envoyé avec succès !'
            ]);
        } catch (Exception $e) {
            // --- RÉPONSE JSON À L'ERREUR ---
            return response()->json([
                'success' => false,
                'message' => "Une erreur est survenue lors de l'envoi de l'email."
            ], 500);
        }
    }

}
