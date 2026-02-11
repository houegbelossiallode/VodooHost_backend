<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public Reservation $reservation;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation->loadMissing('logement.photos', 'logement.user', 'user');
    }

    public function build()
    {
        $logement = $this->reservation->logement;
        $photo    = optional($logement->photos->first())->url;

        return $this->subject('Confirmation de votre réservation - ' . $logement->titre)
            ->view('emails.reservations.success', [
                'reservation' => $this->reservation,
                'logement'    => $logement,
                'photo'       => $photo,
            ]);
    }
}
