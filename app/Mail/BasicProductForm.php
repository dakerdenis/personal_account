<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BasicProductForm extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;

    public function __construct(array $data, string $subject)
    {
        $this->data = $data;
        $this->subject = $subject;
    }

    public function build(): static
    {
        return $this->markdown('mail.basic-product-form');
    }
}
