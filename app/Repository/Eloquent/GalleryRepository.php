<?php

namespace App\Repository\Eloquent;

use App\Models\Gallery;
use App\Repository\GalleryRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class GalleryRepository extends BaseRepository implements GalleryRepositoryInterface
{
    public function __construct(Gallery $model)
    {
        parent::__construct($model);
    }

    public function update(int $id, array $data): bool
    {
        $gallery = $this->find($id);
        $result = $gallery->update($data);
        if (isset($data['delete_images'])) {
            $this->fileRepository->deleteAll($data['delete_images']);
        }
        $order = 0;
        if (isset($data['files'])) {
            foreach ($data['files'] as $key => $file) {
                $result = $this->fileRepository->update($key, $file + ['order_column' => $order]);
                $order++;
            }
        }
        return (bool)$result;
    }

    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

}
