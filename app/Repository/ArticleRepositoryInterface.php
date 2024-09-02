<?php

namespace App\Repository;


use Illuminate\Database\Eloquent\Model;

interface ArticleRepositoryInterface
{
    public function create(array $attributes): Model;

    public function find($id): ?Model;

}
