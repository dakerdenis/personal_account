<?php

namespace App\Mail;

use App\Models\Vacancy;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SendCV extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;
    public UploadedFile $cv;
    public ?Vacancy $vacancy;

    public function __construct(array $data, UploadedFile $cv, ?Vacancy $vacancy = null)
    {
        $this->data = $data;
        $this->cv = $cv;
        $this->vacancy = $vacancy;
    }

    public function build(): static
    {
        return $this->markdown('mail.send-cv')->subject($this->vacancy ? $this->vacancy->title . ' Vacancy' : 'Vacancy form')->attach($this->cv->getRealPath(), [
            'as' => $this->cv->getClientOriginalName(),
            'mime' => $this->cv->getMimeType(),
        ]);
    }
}
