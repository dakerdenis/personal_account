<?php

namespace App\Forms;

use App\Mail\BasicProductForm;
use App\Repository\InsuranceTypeRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class CaseHappenedForm extends FormAbstract
{
    public const FORM_NAME = 'Case happened form';
    public string $formTemplate = 'site.forms.case-happened-form';

    public function validate(array $data): array
    {
        return [''];
    }

public function getData(): void
{
    $insuranceTypesRepository = app(InsuranceTypeRepositoryInterface::class);
    $this->setData([
        'insuranceTypes' => $insuranceTypesRepository->allActiveNested(),
    ]);
}

    protected function sendMail(array $data): void
    {
        $recipients = ['samir@mediadesign.az'];

        Mail::to($recipients)->send(new BasicProductForm($data, 'Case happened form'));
    }
}
