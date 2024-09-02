<?php

namespace App\Repository\Eloquent;

use App\Models\Department;
use App\Repository\DepartmentRepositoryInterface;

class DepartmentRepository extends BaseRepository implements DepartmentRepositoryInterface
{
    public function __construct(Department $model)
    {
        parent::__construct($model);
    }

}
