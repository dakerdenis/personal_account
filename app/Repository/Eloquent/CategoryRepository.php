<?php

namespace App\Repository\Eloquent;

use App\Models\Category;
use App\Repository\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{

    public function __construct(Category $model)
    {
        parent::__construct($model);
    }


    public function create(array $attributes): Model
    {
        $category = $this->model->create($attributes);
        $this->handleMedia($category, $attributes);
        if ($attributes['parent_id']) {
            $parent = $this->find($attributes['parent_id']);
            $category->appendToNode($parent)->save();
        }
        return $category;
    }

    public function update(int $id, array $data): bool
    {
        $category = $this->find($id);
        $result = $category->update($data);
        $this->handleMedia($category, $data);
        if ($data['parent_id'] && ($data['parent_id'] != $category->parent_id)) {
            $parent = $this->find($data['parent_id']);
            $category->appendToNode($parent)->save();
        }
        return $result;
    }

    public function getCategoriesForBlock()
    {
        return $this->model->where('taxonomy', Category::PRODUCTS)->where('active', 1)->whereHas('products', function ($query) {
            $query->where('active', 1);
        })->orderBy('_lft')->get();
    }

}
