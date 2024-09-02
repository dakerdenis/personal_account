<?php

namespace App\Repository\Eloquent;

use App\Models\Complaint;
use App\Repository\ComplaintRepositoryInterface;

class ComplaintRepository extends BaseRepository implements ComplaintRepositoryInterface
{
    public function __construct(Complaint $model)
    {
        parent::__construct($model);
    }

}
