<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $codigo;  // Esta propiedad se usará en la vista

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($codigo)
    {
        // Inicializa la propiedad con el código de verificación
        $this->codigo = $codigo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Retorna la vista que enviará el correo con el código
        return $this->view('emails.verification_code')
                    ->subject('Código de Verificación')
                    ->with([
                        'codigo' => $this->codigo,  // Envía la variable a la vista
                    ]);
    }
}
