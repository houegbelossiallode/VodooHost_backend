<?php

namespace App\Console\Commands;

use App\Models\Notification;
use App\Models\Reservation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class NotifyEndedStays extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-ended-stays';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notifier les utilisateurs dont le séjour est terminé pour laisser un avis';

    /**
     * Execute the console command.
     */
    
    public function handle()
    {
        $reservations = Reservation::with(['user', 'logement.user'])
            ->where('date_fin', '<', now())
            ->where('statut','PAYE')
            ->whereRaw('avis_notif_envoyee IS FALSE')
            ->get();

        foreach ($reservations as $reservation) {
            $visitor = $reservation->user;
            $host    = $reservation->logement->user ?? null;

            if (!$visitor || !$host) {
                continue;
            }

            Notification::create([
                'user_id' => $visitor->id,
                'type'=> 'Avis',
                'title'   => 'Votre séjour est terminé',
                'message' => "Donnez votre avis sur {$host->nom}.",
                'url'     => route('hoost.reviews.create', [
                    'reservation' => $reservation->id,
                    'user'        => $host->id,
                ]),
                'read_at' => null,
            ]);

            DB::table('reservations')
            ->where('id', $reservation->id)
            ->update(['avis_notif_envoyee' => DB::raw('true')]);

        }

        $this->info('Notifications avis générées.');
    }
}



