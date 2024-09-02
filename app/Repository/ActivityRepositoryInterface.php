<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

interface ActivityRepositoryInterface
{
    public function log(string $log_name, Model $model, array $properties = [], string $description = '', object $causer = null): mixed;
}
