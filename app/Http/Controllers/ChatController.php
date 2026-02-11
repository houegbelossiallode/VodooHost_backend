<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    private const ROLE_VISITEUR   = 8;
    private const ROLE_HOTE       = 6;
    private const ROLE_TRADUCTEUR = 7;
    // public function index()
    // {
    //     $conversations = Conversation::where('visiteur_id',Auth::id())
    //         ->orWhere('hote_id',Auth::id())
    //         ->get();

    //     return view('chats.index', compact('conversations'));
    // }


    public function liste(Request $request)
    {
        $sort = $request->get('sort','all'); // all / hosts / visitors / translators

        // 1) Toutes les conversations (sans filtrer sur l'utilisateur connecté)
        $conversations = Conversation::where('actif','OUI')->with([
            'lastMessage.sender',
            'visiteur',
            'hote',
        ])
            ->get();

        // 2) Filtre selon le role_id d’un participant
        // Ici j'interprète le filtre comme :
        // - hosts      : conversations où l'hôte a role_id = ROLE_HOTE
        // - visitors   : conversations où le visiteur a role_id = ROLE_VISITEUR
        // - translators: conversations où l'un des 2 a role_id = ROLE_TRADUCTEUR
        $conversations = match ($sort) {
            'hosts' => $conversations->filter(function ($conv) {
                return $conv->hote && $conv->hote->role_id == self::ROLE_HOTE;
            }),

            'visitors' => $conversations->filter(function ($conv) {
                return $conv->visiteur && $conv->visiteur->role_id == self::ROLE_VISITEUR;
            }),

            'translators' => $conversations->filter(function ($conv) {
                return (
                    ($conv->hote && $conv->hote->role_id == self::ROLE_TRADUCTEUR) ||
                    ($conv->visiteur && $conv->visiteur->role_id == self::ROLE_TRADUCTEUR)
                );
            }),

            default => $conversations,
        };

        // 3) Tri : dernier message en premier
        $conversations = $conversations
            ->sortByDesc(fn($c) => optional($c->lastMessage)->created_at)
            ->values();

        // 4) Compteur de nouveaux messages : TOUTES les notifications,
        // sans filtrer sur l'utilisateur connecté
        $newMessagesCount = Message::where('actif','OUI')->whereRaw('"is_read" IS FALSE')->count();

        return view('chats.index-admin', [
            'conversations'       => $conversations,
            'activeConversation'  => null,
            'messages'            => collect(), // vide pour l’instant
            'newMessagesCount'    => $newMessagesCount,
            'sort'                => $sort,
        ]);
    }



    public function showAdmin(Request $request, Conversation $conversation)
    {
        $sort = $request->get('sort', 'all'); // all / hosts / visitors / translators

        // 1) Toutes les conversations (sans filtrer sur Auth::id())
        $conversations = Conversation::where('actif','OUI')->with([
            'lastMessage.sender',
            'visiteur',
            'hote',
        ])->get();

        // 2) Filtre selon le rôle
        $conversations = match ($sort) {
            'hosts' => $conversations->filter(function ($conv) {
                return $conv->hote && $conv->hote->role_id == self::ROLE_HOTE;
            }),

            'visitors' => $conversations->filter(function ($conv) {
                return $conv->visiteur && $conv->visiteur->role_id == self::ROLE_VISITEUR;
            }),

            'translators' => $conversations->filter(function ($conv) {
                return (
                    ($conv->hote && $conv->hote->role_id == self::ROLE_TRADUCTEUR) ||
                    ($conv->visiteur && $conv->visiteur->role_id == self::ROLE_TRADUCTEUR)
                );
            }),

            default => $conversations,
        };

        // 3) Tri : dernier message en premier
        $conversations = $conversations
            ->sortByDesc(fn($c) => optional($c->lastMessage)->created_at)
            ->values();

        // 4) Messages de la conversation active
        $messages = $conversation->messages()
            ->with('sender')
            ->orderBy('created_at')
            ->get();

        return view('chats.index-admin', [
            'conversations'      => $conversations,
            'activeConversation' => $conversation,
            'messages'           => $messages,
            'sort'               => $sort,
        ]);
    }


    public function index(Request $request)
    {
        $user = Auth::user();
        // $conversations = Conversation::where('visiteur_id',Auth::id())
        //     ->orWhere('hote_id',Auth::id())
        //     ->get();
        $sort = $request->get('sort','all'); // all / hosts / visitors / translators
        // 1) Toutes mes conversations (je suis visiteur OU hôte)
        $conversations = Conversation::where('actif','OUI')->with([
            'lastMessage.sender',
            'visiteur',
            'hote',
        ])
            ->where(function ($q) use ($user) {
                $q->where('visiteur_id', $user->id)
                    ->orWhere('hote_id', $user->id);
            })
            ->get();

        // 2) Filtre selon le role_id de l’AUTRE participant
        $conversations = match ($sort) {
            'hosts' => $conversations->filter(function ($conv) {
                $other = $conv->otherUser();
                return $other && $other->role_id == self::ROLE_HOTE;
            }),

            'visitors' => $conversations->filter(function ($conv) {
                $other = $conv->otherUser();
                return $other && $other->role_id == self::ROLE_VISITEUR;
            }),

            'translators' => $conversations->filter(function ($conv) {
                $other = $conv->otherUser();
                return $other && $other->role_id == self::ROLE_TRADUCTEUR;
            }),

            default => $conversations, // "all"
        };

        // 3) Tri : dernier message en premier
        $conversations = $conversations
            ->sortByDesc(fn($c) => optional($c->lastMessage)->created_at)
            ->values();

        $newMessagesCount = Message::where('actif','OUI')->whereHas('conversation', function ($q) use ($user) {
            $q->where('visiteur_id', $user->id)
                ->orWhere('hote_id', $user->id);
        })
            ->where('sender_id', '!=', $user->id) // pas mes propres messages
            //->where('is_read',false)               // à toi de gérer ce champ
            ->whereRaw('"is_read" IS FALSE')
            ->count();
        return view('chats.index', [
            'conversations' => $conversations,
            'activeConversation' => null,
            'messages' => collect(), // vide pour l'instant
            'newMessagesCount' => $newMessagesCount,
            'sort' => $sort
        ]);
    }

    /**
     * Affiche une conversation spécifique avec ses messages
     */
    public function show(Conversation $conversation)
    {
        $messages = $conversation->messages()->with('sender')->get();
        $conversations = Conversation::where('actif','OUI')->where('visiteur_id', Auth::id())
            ->orWhere('hote_id', Auth::id())
            ->get();
        return view('chats.index', [
            'conversations' => $conversations,
            'activeConversation' => $conversation,
            'messages' => $messages,

        ]);
    }



    public function send(Request $request, Conversation $conversation)
    {
        $data = [
            'conversation_id' => $conversation->id,
            'sender_id' => Auth::id(),
            'message' => $request->message
        ];

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }

        $message = Message::create($data);

        //broadcast(new NewMessageEvent($message->load('sender')))->toOthers();

        return back();
    }

    public function start(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'logement_id' => 'nullable|exists:logements,id',
            'message' => 'required|string'
        ]);

        //Vérifier si la conversation existe déjà
        $conversation = Conversation::where(function ($query) use ($request) {
            $query->where('visiteur_id', Auth::id())
                ->where('hote_id', $request->receiver_id);
        })->orWhere(function ($query) use ($request) {
            $query->where('visiteur_id', $request->receiver_id)
                ->where('hote_id', Auth::id());
        })->where('logement_id', $request->logement_id)->first();

        //Si aucune conversation existante → créer une
        if (!$conversation) {
            $conversation = Conversation::create([
                'logement_id' => $request->logement_id,
                'visiteur_id' => Auth::id(),
                'hote_id' => $request->receiver_id,
            ]);
        }

        //Ajouter le premier message
        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => Auth::id(),
            'message' => $request->message
        ]);

        // redirect vers la conversation
        return redirect()->route('hoost.chats.show', $conversation->id);
    }

    private function isParticipant($conversation)
    {
        return Auth::id() == $conversation->user_one || Auth::id() == $conversation->hote_id;
    }



    public function update(Request $request, Message $message)
    {
        //dd($message);
        // Vérifier que l'utilisateur est bien l'expéditeur du message
        if ($message->sender_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Non autorisé à modifier ce message.'
            ], 403);
        }

        $validated = $request->validate([
            'message' => 'required',
        ]);

        $message->update([
            'message' => $validated['message'],
        ]);

        return response()->json([
            'success' => true,
            'message' => $message->message
        ]);
    }


    public function destroy(Message $message)
    {
        // Vérifier que l'utilisateur est bien l'expéditeur du message
        if ($message->sender_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Non autorisé à supprimer ce message.'
            ], 403);
        }

        if($message->actif === 'OUI'){
            $message->actif = 'NON';
        } else {
            $message->actif = 'OUI';
        }
        $message->save();   

        return response()->json([
            'success' => true,
            'message' => 'Message supprimé avec succès.'
        ]);
    }
}
