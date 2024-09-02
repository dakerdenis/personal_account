<?php

namespace App\Repository\Eloquent;

use App\Models\File;
use App\Repository\FileModelRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class FileModelRepository extends BaseRepository implements FileModelRepositoryInterface
{
    public function __construct(File $model)
    {
        parent::__construct($model);
    }

    public function create(array $attributes): Model
    {
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $locale) {
            if (isset($attributes['file:' . $localeCode])) {
                $attributes['path:' . $localeCode] = $attributes['file:' . $localeCode]->storeAs(
                    '/uploaded_files/' . Str::random(4),
                    Str::transliterate($attributes['file:' . $localeCode]->getClientOriginalName()),
                    'public'
                );
            }
        }

        return $this->model->create($attributes);
    }

    public function update(int $id, array $data): bool
    {
        $file = $this->model->find($id);
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $locale) {
            if (isset($data['file:' . $localeCode])) {
                $data['path:' . $localeCode] = $data['file:' . $localeCode]->storeAs(
                    '/uploaded_files/' . Str::random(4),
                    Str::transliterate($data['file:' . $localeCode]->getClientOriginalName()),
                    'public'
                );
            }
        }

        return $file->update($data);
    }
}
