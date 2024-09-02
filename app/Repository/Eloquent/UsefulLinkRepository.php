<?php

namespace App\Repository\Eloquent;

use App\Models\UsefulLink;
use App\Repository\UsefulLinkRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class UsefulLinkRepository extends BaseRepository implements UsefulLinkRepositoryInterface
{
    public function __construct(UsefulLink $model)
    {
        parent::__construct($model);
    }

    public function create(array $attributes): Model
    {
        $article = $this->model->create($attributes);
        $this->handleMedia($article, $attributes);

        return $article;
    }

    public function update(int $id, array $data): bool
    {
        $article = $this->find($id);
        $this->handleMedia($article, $data);

        return $article->update($data);
    }
}
