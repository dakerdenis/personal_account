<?php

namespace App\Repository\Eloquent;

use App\Models\Navigation;
use App\Repository\NavigationRepositoryInterface;

class NavigationRepository extends BaseRepository implements NavigationRepositoryInterface
{
    public function __construct(Navigation $model)
    {
        parent::__construct($model);
    }

    public function getNavigationMenuItems(string $machine_name): mixed
    {
        return $this->model->where('machine_name', $machine_name)->first()?->items()->with('translations')->active()->orderBy('_lft')->get()->toTree();
    }

    public function getNavigationMenuItemsAll(string $machine_name): mixed
    {
        $navigation = $this->model->where('machine_name', $machine_name)->first();
        return $navigation ? $navigation->items()->orderBy('_lft')->get()->toTree() : [];
    }

    public function getNavigationMenuItemsAllFlat(string $machine_name): mixed
    {
        $navigation = $this->model->where('machine_name', $machine_name)->first();
        return $navigation ? $navigation->items()->orderBy('_lft')->get()->toFlatTree() : [];
    }

    public function getNavigationMenuItemsFlat(string $machine_name): mixed
    {
        return $this->model->where('machine_name', $machine_name)->first()->items()->active()->orderBy('_lft')->get()->toFlatTree();
    }

}
