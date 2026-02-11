<?php

namespace App\Http\Controllers;

use App\Mail\ContactHostMail;
use App\Models\Logement;
use App\Models\Message;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactHoteController extends Controller
{
    // public function send($host_id,$logement_id,Request $request)
    // {
    //     $data = $request->validate([
    //         'nom'          => 'required|string|max:100',
    //         'prenom'       => 'required|string|max:100',
    //         'email'        => 'required|email|max:190',
    //         'message'      => 'required',
    //         'copy_to_email'=> 'nullable|boolean',
    //         'logement_id'   => 'required|exists:logements,id',
    //     ]);
    //     $logement = Logement::findOrFail($data['logement_id']);
    //          Message::create([
    //             'logement_id'   => $logement_id,
    //             'destinataire_id' => $host_id,
    //             'email'     => $data['email'],
    //             'nom'=> $data['nom'],
    //             'prenom'=> $data['prenom'],
    //             'contenu'   => $data['message'],
    //         ]);
    //     $user = User::where('id',$host_id)->first();
    //     // 3) Envoyer les emails
    //     Mail::to($user->email)->send(new ContactHostMail($data, $logement));            // à l’hôte
    //     if ($request->boolean('copy_to_email')) {
    //         Mail::to($data['email'])->send(new ContactHostMail($data, $logement, true)); // copie au visiteur
    //     }
    //     return response()->json([
    //         'success'    => true,
    //         'message'    => 'Message envoyé avec succès !'
    //     ]);
    // }


    public function send(User $host, ?Logement $logement = null, Request $request)
    {
        try{
          $data = $request->validate([
            'nom'           => 'required|string|max:100',
            'prenom'        => 'required|string|max:100',
            'email'         => 'required|email|max:190',
            'message'       => 'required'
        ]);
        
        Mail::to($host->email)->send(new ContactHostMail($data, $host, $logement));
        return back()->with('success', 'Message envoyé avec succès');
        }catch(Exception $e){
         return redirect()->back()->with('error','Une erreur est survenue' . $e->getMessage());
        }
        
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Message envoyé avec succès !',
        // ]);
    }
}
