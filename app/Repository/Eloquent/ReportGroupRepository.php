<?php

namespace App\Repository\Eloquent;

use App\Models\ReportGroup;
use App\Repository\ReportGroupRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ReportGroupRepository extends BaseRepository implements ReportGroupRepositoryInterface
{
    public function __construct(ReportGroup $model)
    {
        parent::__construct($model);
    }


    public function update(int $id, array $data): bool
    {
        $group = $this->find($id);
        if ($data['reports'] ?? false) {
            $files = [];
            foreach ($data['reports'] as $order => $file) {
                $files[$file] = ['order' => $order];
            }
            $group->files()->sync($files);
            unset($data['reports']);
        }

        return $group->update($data);
    }

    public function create(array $attributes): Model
    {
        $group = $this->model->create($attributes);
        if ($attributes['reports'] ?? false) {
            $files = [];
            foreach ($attributes['reports'] as $order => $file) {
                $files[$file] = ['order' => $order];
            }
            $group->files()->sync($files);
            unset($attributes['files']);
        }

        return $group;
    }
}
