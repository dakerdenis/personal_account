<?php

namespace App\Repository;

interface NavigationRepositoryInterface
{
    public function all(): mixed;

    public function update(int $id, array $data): bool;

    public function getNavigationMenuItems(string $machine_name): mixed;

    public function getNavigationMenuItemsFlat(string $machine_name): mixed;
}
