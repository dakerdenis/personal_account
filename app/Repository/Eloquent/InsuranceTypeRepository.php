<?php

namespace App\Repository\Eloquent;

use App\Models\FaqEntity;
use App\Models\InsuranceType;
use App\Repository\FaqRepositoryInterface;
use App\Repository\InsuranceTypeRepositoryInterface;

class InsuranceTypeRepository extends BaseRepository implements InsuranceTypeRepositoryInterface
{
    public function __construct(InsuranceType $model)
    {
        parent::__construct($model);
    }

}
