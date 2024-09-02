<?php

namespace App\Repository\Eloquent;

use App\Models\MenuItem;
use App\Repository\MenuItemRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class MenuItemRepository extends BaseRepository implements MenuItemRepositoryInterface
{
    public function __construct(MenuItem $model)
    {
        parent::__construct($model);
    }

    public function create(array $attributes): Model
    {
        $menu_item = $this->model->create($attributes);
        $this->handleMedia($menu_item, $attributes);
        if ($attributes['parent_id']) {
            $parent = $this->find($attributes['parent_id']);
            $menu_item->appendToNode($parent)->save();
        }
        return $menu_item;
    }

    public function update(int $id, array $data): bool
    {
        $menu_item = $this->find($id);
        $result = $menu_item->update($data);
        $this->handleMedia($menu_item, $data);
        if (isset($data['parent_id']) && $data['parent_id'] && ($data['parent_id'] != $menu_item->parent_id)) {
            $parent = $this->find($data['parent_id']);
            $menu_item->appendToNode($parent)->save();
        }
        return $result;
    }

}
