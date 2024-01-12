<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuotationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $ref_no;

    public function __construct($ref_no)
    {
        $this->ref_no = $ref_no;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $ref_no = $this->ref_no;
        return $this->view('email-templates.quotation',['ref_no'=>$ref_no]);
    }
}
