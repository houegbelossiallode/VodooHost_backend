<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Conversation extends Model
{
     protected $guarded = [];

    public function messages()
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'asc');
    }

    public function visiteur()
    {
        return $this->belongsTo(User::class, 'visiteur_id');
    }

    public function hote()
    {
        return $this->belongsTo(User::class, 'hote_id');
    }

    public function lastMessage(){
       return $this->hasOne(Message::class)->latest();
    }

    public function otherUser()
    {
        if (Auth::id() == $this->visiteur_id) {
            return $this->hote ?? $this->visiteur;
        }
        return $this->visiteur ?? $this->hote;
    }

    public function messagesTrashed()
    {
        return $this->hasMany(Message::class)
            ->withTrashed()
            ->orderBy('created_at', 'asc');
    }


    

    // Récupère l'autre utilisateur dans une conversation privé (2 personnes)
    // public function otherUser()
    // {
    //     return $this->users()
    //         ->where('user_id', '!=',Auth::id())
    //         ->first();
    // }
}
