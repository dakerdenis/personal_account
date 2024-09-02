<?php

namespace App\Repository\Eloquent;

use App\Models\Vacancy;
use App\Repository\VacancyRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class VacancyRepository extends BaseRepository implements VacancyRepositoryInterface
{
    public function __construct(Vacancy $model)
    {
        parent::__construct($model);
    }

    public function create(array $attributes): Model
    {
        $vacancy =  parent::create($attributes);
        $this->handleFiles($vacancy, $attributes);

        return $vacancy;
    }

    public function update(int $id, array $data): bool
    {
        $vacancy = $this->model->findOrFail($id);
        $this->handleFiles($vacancy, $data);

        return $vacancy->update($data);
    }

    public function handleFiles(Vacancy $vacancy, array &$data)
    {
        if ($data['files'] ?? false) {
            $files = [];
            foreach ($data['files'] as $order => $file) {
                $files[$file] = ['order' => $order];
            }
            $vacancy->files()->sync($files);
            unset($data['files']);
        }
    }
}
