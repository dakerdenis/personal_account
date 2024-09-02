<?php

namespace App\Repository;

use Illuminate\Support\Collection;

interface StaffRepositoryInterface
{
    public function all(): Collection;
}
