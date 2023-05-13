<?php

namespace App\Mail;

use App\Http\Controllers\UsuarioController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    private $mail = "";

    public $subject = "Email de verificación MONEYMONITOR";
    /**
     * Create a new message instance.
     */
    public function __construct($mail)
    {
        $this->mail = $mail;
    }
    public function build() {

        return $this->view('mails.verification', ['mail' => $this->mail]);
    }
}
