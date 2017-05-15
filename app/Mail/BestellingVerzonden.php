<?php

namespace App\Mail;

//use App\Klanten;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BestellingVerzonden extends Mailable
{
    use Queueable, SerializesModels;
    
        public $user;
        public $huurovereenkomst;
        public $auto;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $huurovereenkomst, $auto)
    {
        $this->user = $user;
        $this->huurovereenkomst = $huurovereenkomst;
        $this->auto = $auto;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.bestelling.verzonden');
    }
}
