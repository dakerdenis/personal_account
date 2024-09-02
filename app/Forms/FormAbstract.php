<?php

namespace App\Forms;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class FormAbstract
{
    public string $formTemplate = 'site.forms.basic';
    private array $data = [];
    public function __construct(private Model $model)
    {
        $this->getData();
    }

    abstract public function validate(array $data): array;

    public function renderForm(): View
    {
        $data = $this->data;
        $data['model'] = $this->model;
        return view($this->formTemplate, $data);
    }

    abstract protected function sendMail(array $data): void;

    public function handle(Request $request): void
    {
        $validated = $this->validate($request->all());
        $this->sendMail($validated);
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function getData(): void
    {

    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }
}
