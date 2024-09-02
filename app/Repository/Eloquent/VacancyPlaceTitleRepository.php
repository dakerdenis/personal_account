<?php

namespace App\Repository\Eloquent;

use App\Models\VacancyPlaceTitle;
use App\Repository\VacancyPlaceTitleRepositoryInterface;

class
VacancyPlaceTitleRepository extends BaseRepository implements VacancyPlaceTitleRepositoryInterface
{
    public function __construct(VacancyPlaceTitle $model)
    {
        parent::__construct($model);
    }

}
