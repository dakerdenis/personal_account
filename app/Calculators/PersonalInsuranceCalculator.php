<?php

namespace App\Calculators;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PersonalInsuranceCalculator
{
    public const CALCULATOR_NAME = 'ozal anket';
    public string $formTemplate = 'site.calculators.personal';
    private array $data = [];
    public function __construct(private Model $model)
    {
        $this->getData();
    }

    public function render()
    {
        $data = $this->data;
        $data['title'] = $this->model->calculator_title;

        return view($this->formTemplate, compact('data'));
    }

    public function getData(): void
    {
        $data = Cache::get('insureapi');
        $this->data = $data;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }
}
