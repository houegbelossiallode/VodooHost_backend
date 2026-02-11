<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{

    

    public function index(Request $request)
    {
        // $user = Auth::user();
        // $notifications = $user->notifications()
        //     ->latest()
        //     ->paginate(15);

        // // Marquer les notifications comme lues lorsqu'elles sont consultées
        // $user->unreadNotifications()->update(['read_at' => now()]);

        $user = Auth::user();
        // Base de la requête : les notifs de l'utilisateur, les plus récentes d'abord
        $query = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc');

        // 1) Recherche texte (titre + message)
        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'ILIKE', "%{$search}%")
                    ->orWhere('message', 'ILIKE', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            if ($status === 'unread') {
                $query->whereNull('read_at');
            } elseif ($status === 'read') {
                $query->whereNotNull('read_at');
            }
        }

        // 2) Filtre par type (sort)
        if ($sort = $request->input('sort')) {
            if ($sort !== 'all') {
                $query->where('type', $sort);
            }
        } else {
            // valeur par défaut
            $request->merge(['sort' => 'all']);
        }

        // 3) Pagination
        $notifications = $query->paginate(10)->withQueryString();

        // 4) Nombre de non lues (global, peu importe les filtres)
        $unreadCount = Notification::where('user_id', $user->id)
            ->whereNull('read_at')
            ->count();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->where('id', $id)->firstOrFail();

        if ($notification->read_at == null) {
            $notification->update(['read_at' => now()]);
        }

        return response()->json(['success' => true]);
    }

    public function markAllRead()
    {
        $user = Auth::user();
        // Si tu utilises TON propre modèle Notification
        Notification::where('user_id', $user->id)
            ->whereNull('read_at')
            ->update([
                'read_at'   => now(),
                'updated_at' => now(),
            ]);

        return response()->json(['success' => true]);
    }


    // public function unreadCount()
    // {
    //     $count = Auth::user()->notifications()->whereNull('read_at')->count();

    //     return response()->json(['count' => $count]);
    // }

    public function edit()
    {
        $preferences = Auth::user()->notificationPreferences;
        return view('profile.notifications', compact('preferences'));
    }

    public function update(Request $request)
    {
        $preferences = Auth::user()->notificationPreferences;

        DB::table('notification_preferences')
            ->where('id', $preferences->id)
            ->update([
                'email'                 => DB::raw($request->boolean('email') ? 'TRUE' : 'FALSE'),
                'sms'                   => DB::raw($request->boolean('sms') ? 'TRUE' : 'FALSE'),
                'in_app'                => DB::raw($request->boolean('in_app') ? 'TRUE' : 'FALSE'),
                'reservation_confirmee' => DB::raw($request->boolean('reservation_confirmee') ? 'TRUE' : 'FALSE'),
                'annulation_reservation' => DB::raw($request->boolean('annulation_reservation') ? 'TRUE' : 'FALSE'),
                'nouveau_message'       => DB::raw($request->boolean('nouveau_message') ? 'TRUE' : 'FALSE'),
            ]);
        // $preferences->update([
        //     'email' => $request->boolean('email'),
        //     'sms' => $request->boolean('sms'),
        //     'in_app' => $request->boolean('in_app'),
        //     'reservation_confirmee' => $request->boolean('reservation_confirmee'),
        //     'annulation_reservation' => $request->boolean('annulation_reservation'),
        //     'nouveau_message' => $request->boolean('nouveau_message'),
        // ]);

        return back()->with('success', 'Préférences de notification mises à jour avec succès.');
    }
}
