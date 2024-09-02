<?php

namespace App\Repository;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface EloquentRepositoryInterface
{
    public function create(array $attributes): Model;

    public function find($id): ?Model;

    public function reorder(object $request): mixed;

    public function filterAndPaginate(Request $request, int $per_page = 12, array $order_by = ['created_at', 'desc']): mixed;

    public function allActiveNested(array $where = null, int $paginate = null): mixed;
}
