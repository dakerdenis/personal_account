<?php

namespace App\Forms;

use App\Mail\BasicProductForm;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class CheckComplaintForm extends FormAbstract
{
    public const FORM_NAME = 'Complaints & Check Complaint form ';
    public string $formTemplate = 'site.forms.check-complaint';

    public function validate(array $data): array
    {
        return [];
    }

    protected function sendMail(array $data): void
    {
    }
}
