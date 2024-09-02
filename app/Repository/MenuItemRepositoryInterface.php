<?php

namespace App\Repository;

interface MenuItemRepositoryInterface
{
    public function all();

    public function update(int $id, array $data): bool;
}
