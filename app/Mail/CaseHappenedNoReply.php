<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CaseHappenedNoReply extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function build(): static
    {
        return $this->markdown('mail.case-happened-form-no-reply')->subject(__('site.case_happened_no_reply_subject'));
    }
}
