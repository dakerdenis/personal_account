<?php

namespace App\Repository\Eloquent;

use App\Models\ComplaintStatus;
use App\Models\Contact;
use App\Repository\ComplaintStatusRepositoryInterface;
use App\Repository\ContactRepositoryInterface;

class ComplaintStatusRepository extends BaseRepository implements ComplaintStatusRepositoryInterface
{
    public function __construct(ComplaintStatus $model)
    {
        parent::__construct($model);
    }

}
