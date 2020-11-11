<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaqueteMail extends Mailable {
    use Queueable, SerializesModels;
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data) {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     *
     * para sendgrrid
     * usuario : EmmanuelHernandez
     * contraseña : quesevayanalquioteconsusconntrasenastanpendejas
     * contraseña de correo intelopack@intelo.com.mx es 1nt3l0#2020*
     * 
     * php artisan cache:clear
     * php artisan route:clear
     * php artisan config:clear
     * php artisan view:clear
      */
    public function build() {
        return $this->subject('Paquete en ruta')->view('email_paquete');
    }
}
