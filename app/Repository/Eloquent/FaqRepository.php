<?php

namespace App\Repository\Eloquent;

use App\Models\FaqEntity;
use App\Repository\ContactRepositoryInterface;
use App\Repository\FaqRepositoryInterface;

class FaqRepository extends BaseRepository implements FaqRepositoryInterface
{
    public function __construct(FaqEntity $model)
    {
        parent::__construct($model);
    }

}
