<?php

namespace App\Repository\Eloquent;

use App\Models\Article;
use App\Models\Category;
use App\Repository\ArticleRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ArticleRepository extends BaseRepository implements ArticleRepositoryInterface
{

    public function __construct(Article $model)
    {
        parent::__construct($model);
    }

    public function create(array $attributes): Model
    {
        /** @var Article $article */
        $article = $this->model->create($attributes);
        $this->handleCategories($attributes, $article);
        $this->handleMedia($article, $attributes);
        if ($attributes['files'] ?? false) {
            $files = [];
            foreach ($attributes['files'] as $order => $file) {
                $files[$file] = ['order' => $order];
            }
            $article->files()->sync($files);
            unset($attributes['files']);
        }
        if ($attributes['useful_links'] ?? false) {
            $files = [];
            foreach ($attributes['useful_links'] as $order => $file) {
                $files[$file] = ['order' => $order];
            }
            $article->usefulLinks()->sync($files);
            unset($attributes['useful_links']);
        }

        return $article;
    }

    public function update(int $id, array $data): bool
    {
        /** @var Article $article */
        $article = $this->find($id);
        $this->handleCategories($data, $article);
        $this->handleMedia($article, $data);

            $files = [];
            foreach ($data['files'] ?? [] as $order => $file) {
                $files[$file] = ['order' => $order];
            }
            $article->files()->sync($files);
            unset($data['files']);

            $files = [];
            foreach ($data['useful_links'] ?? [] as $order => $file) {
                $files[$file] = ['order' => $order];
            }
            $article->usefulLinks()->sync($files);
            unset($data['useful_links']);

        return $article->update($data);
    }

    public function lastNews(): mixed
    {
        return $this->model->whereHas('categories', function ($query) {
            $query->where('categories.taxonomy', Category::BLOG);
        })->orderByDesc('date')->take(3)->get();
    }

    public function search(Request $request, ?int $paginate = null, $term = null): Collection|LengthAwarePaginator
    {
        $this->model = $this->baseState;
        if ($term) {
            $this->model = $this->model->whereHas('categories', function ($query) use ($term) {
                $query->where('taxonomy', $term);
            });
        }
        return parent::search($request, $paginate);
    }

}
