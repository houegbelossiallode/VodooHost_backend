<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Notifications\ResetPassword;

class PasswordResetController extends Controller
{

    public function password(Request $request)
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request){
        try{
            //dd($request->all());
          $request->validate([
            'email'=> 'required|email'
          ]);
          //On recherche l'utilisateur
          $user = User::where('email',$request->email)->first();
          if(!$user){
              return redirect()->route('hoost.login')->with('error','Aucun utilisateur trouvé pour cette adresse email');
          } 
          $token = Str::random(60);
          DB::table('password_reset_tokens')->updateOrInsert(
            ['email'=> $request->email],
            [
              'token'=> $token,
              'created_at' => Carbon::now()
            ]
            );

          //$resetLink = url('/reset-password/' . $token . '?email=' . urlencode($request->email));
          //dd($user);
          Mail::to($user->email)->send(new ResetPasswordNotification($user,$token));
          return redirect()->route('hoost.login')->with('success','Un lien de réinitialisation a été envoyé à vôtre adresse email');
        }catch(Exception $e){
            return redirect()->route('hoost.login')->with(['error' => 'Une erreur inattendue s\'est produite : ' . $e->getMessage()]);
        }
    }


    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required'
        ],[
            'email.required'=> "l'email est requis"
        ]);

        $record = DB::table('password_reset_tokens')->where([
            'email' => $request->email,
            'token' => $request->token,
        ])->first();

        if (!$record) {
            return redirect()->back()->with('error','Email ou token invalide.');
        }

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password),
        ]);
        DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();
        return redirect()->route('hoost.login')->with('success', 'Mot de passe réinitialisé avec succès!');
    }
}
