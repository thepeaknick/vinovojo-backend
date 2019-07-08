<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RateCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    private $object;

    public $objectName;
    public $objectType;


    public function __construct($object)
    {

        $this->from('vino@gmail.com');

        
        $this->object = $object;

        $this->objectType = ( $this->object->flag == app('\App\Wine')->flag ) ? 'vino' : 'vinariju';
        $this->object->transliterate(1, ['name']);
        $this->objectName = $this->object->name;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject( 'Dodat komentar' );
        return $this->view( 'rate_notification' );
    }
}
