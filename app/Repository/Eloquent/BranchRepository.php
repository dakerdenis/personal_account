<?php

namespace App\Repository\Eloquent;

use App\Models\Branch;
use App\Repository\BranchRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

class BranchRepository extends BaseRepository implements BranchRepositoryInterface
{

    public function __construct(Branch $model)
    {
        parent::__construct($model);
    }


    public function create(array $attributes): Model
    {
        $category = $this->model->create($attributes);
        $this->handleMedia($category, $attributes);

        return $category;
    }

    public function update(int $id, array $data): bool
    {
        $category = $this->find($id);
        $result = $category->update($data);
        $this->handleMedia($category, $data);

        return $result;
    }


    public function searchByQuery(ProductsFilterDTO $dto, $builder = null, string $locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        $words = collect(explode(' ', $dto->getSearchQuery()));
        if ($builder) {
            $builder->where(function ($query) use ($dto, $words, $locale) {
                $words->take(3)->each(function ($word, $key) use ($query, $locale) {
                    if ($key === 0) {
                        $query->where(function ($subQuery) use ($word, $locale) {
                            $subQuery->whereHas('categories', function ($categoryQuery) use ($word, $locale) {
                                $categoryQuery->whereTranslationLike('title', '%' . $word . '%', $locale);
                            })->orWhereHas('tags', function ($tagQuery) use ($word, $locale) {
                                $tagQuery->whereTranslationLike('title', '%' . $word . '%', $locale);
                            })->orWhereHas('color', function ($colorQuery) use ($word, $locale) {
                                $colorQuery->whereTranslationLike('title', '%' . $word . '%', $locale);
                            })->orWhereTranslationLike('title', '%' . $word . '%', $locale)->orWhereTranslationLike('description', '%' . $word . '%', $locale)->orWhere('code', $word);
                        });
                    } else {
                        $query->orWhere(function ($subQuery) use ($word, $locale) {
                            $subQuery->whereHas('categories', function ($categoryQuery) use ($word, $locale) {
                                $categoryQuery->whereTranslationLike('title', '%' . $word . '%', $locale);
                            })->orWhereHas('tags', function ($tagQuery) use ($word, $locale) {
                                $tagQuery->whereTranslationLike('title', '%' . $word . '%', $locale);
                            })->orWhereHas('color', function ($colorQuery) use ($word, $locale) {
                                $colorQuery->whereTranslationLike('title', '%' . $word . '%', $locale);
                            })->orWhereTranslationLike('title', '%' . $word . '%', $locale)->orWhereTranslationLike('description', '%' . $word . '%', $locale)->orWhere('code', $word);
                        });
                    }
                });
            });
        }
        $this->model = $this->model->where(function ($query) use ($dto, $words, $locale) {
            $words->take(3)->each(function ($word, $key) use ($query, $locale) {
                if ($key === 0) {
                    $query->where(function ($subQuery) use ($word, $locale) {
                        $subQuery->whereHas('categories', function ($categoryQuery) use ($word, $locale) {
                            $categoryQuery->whereTranslationLike('title', '%' . $word . '%', $locale);
                        })->orWhereHas('tags', function ($tagQuery) use ($word, $locale) {
                            $tagQuery->whereTranslationLike('title', '%' . $word . '%', $locale);
                        })->orWhereHas('color', function ($colorQuery) use ($word, $locale) {
                            $colorQuery->whereTranslationLike('title', '%' . $word . '%', $locale);
                        })->orWhereTranslationLike('title', '%' . $word . '%', $locale)->orWhereTranslationLike('description', '%' . $word . '%', $locale)->orWhere('code', $word);
                    });
                } else {
                    $query->orWhere(function ($subQuery) use ($word, $locale) {
                        $subQuery->whereHas('categories', function ($categoryQuery) use ($word, $locale) {
                            $categoryQuery->whereTranslationLike('title', '%' . $word . '%', $locale);
                        })->orWhereHas('tags', function ($tagQuery) use ($word, $locale) {
                            $tagQuery->whereTranslationLike('title', '%' . $word . '%', $locale);
                        })->orWhereHas('color', function ($colorQuery) use ($word, $locale) {
                            $colorQuery->whereTranslationLike('title', '%' . $word . '%', $locale);
                        })->orWhereTranslationLike('title', '%' . $word . '%', $locale)->orWhereTranslationLike('description', '%' . $word . '%', $locale)->orWhere('code', $word);
                    });
                }
            });
        });

        return $this;
    }

    public function search(Request $request, ?int $paginate = null): Collection|LengthAwarePaginator
    {
        $this->model = $this->model->where('active', 1);
        $collection = new Collection();
        if ($request->get('query')) {
            $combinations = $this->getCombinations($request);
            foreach ($combinations as $combo) {
                $events = clone $this->model;
                foreach ($combo as $word) {
                    $events = $events->where(function ($q) use ($word) {
                        $q->whereTranslationLike('title', "%$word%", App::getLocale());
                    });
                }
                if ($events->count()) {
                    foreach ($events->get() as $event) {
                        $collection->push($event);
                    }
                }
            }
        }
        if ($paginate) return $collection->unique()->paginate($paginate);
        return $collection->unique();
    }
}
