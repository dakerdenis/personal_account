<?php

namespace App\Repository\Eloquent;

use App\Models\ReportYear;
use App\Repository\ReportYearRepositoryInterface;

class ReportYearRepository extends BaseRepository implements ReportYearRepositoryInterface
{
    public function __construct(ReportYear $model)
    {
        parent::__construct($model);
    }

}
