<?php

namespace App\Mail;

use App\Models\Logement;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class ContactHostMail extends Mailable
{
    use Queueable, SerializesModels;

     
    //  public function __construct(
    //     public array $data,
    //     public User $host,
    //     public ?Logement $logement = null
    // ) {}

    // public function build()
    // {
    //     $subject = $this->logement
    //         ? "Nouveau message pour votre logement : {$this->logement->titre}"
    //         : "Nouveau message d'un visiteur (sans logement)";

    //     // return $this->subject($subject);
    //      return $this->subject($subject)
    //         ->view('emails.contact_host');
    // }
    // /**
    //  * Get the attachments for the message.
    //  *
    //  * @return array<int, \Illuminate\Mail\Mailables\Attachment>
    //  */
    // public function attachments(): array
    // {
    //     return [];
    // }

    public function __construct(
        public array $data,
        public $host,
        public $logement = null
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->logement
                ? 'Nouveau message concernant votre logement'
                : 'Nouveau message d’un visiteur',
            replyTo: [
                new Address(
                    $this->data['email'],
                    $this->data['prenom'].' '.$this->data['nom']
                )
            ]
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact_host'
        );
    }
}
