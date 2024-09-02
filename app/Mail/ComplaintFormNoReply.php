<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ComplaintFormNoReply extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function build(): static
    {
        return $this->markdown('mail.complaint-form-no-reply')->subject(__('site.complaint_no_reply_subject'));
    }
}
