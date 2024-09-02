<?php

namespace App\Repository\Eloquent;

use App\Models\Contact;
use App\Repository\ContactRepositoryInterface;

class ContactRepository extends BaseRepository implements ContactRepositoryInterface
{
    public function __construct(Contact $model)
    {
        parent::__construct($model);
    }

}
