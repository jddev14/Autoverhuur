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
        public $autosdet;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $huurovereenkomst, $autosdet)
    {
        $this->user = $user;
        $this->huurovereenkomst = $huurovereenkomst;
        $this->autosdet = $autosdet;
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
