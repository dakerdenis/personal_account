<?php

namespace App\Repository\Eloquent;

use App\DTO\ProductsFilterDTO;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Repository\EloquentRepositoryInterface;
use App\Repository\FileRepositoryInterface;
use App\Repository\GeneralSettingRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class BaseRepository implements EloquentRepositoryInterface
{

    public FileRepositoryInterface $fileRepository;

    protected mixed $model;

    protected Model $baseState;

    public function __construct(Model $model, bool $fileRepository = true)
    {
        $this->model = $model;
        $this->baseState = $model;
        if ($fileRepository) $this->fileRepository = \app(FileRepositoryInterface::class);
    }


    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    public function deleteAll(array $ids): ?bool
    {
        $result = true;
        foreach ($ids as $id) {
            $result = $this->delete($id);
        }
        return $result;
    }

    public function delete(int $id): ?bool
    {
        return $this->find($id)->delete();
    }

    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    public function findMultiple(array $ids): ?Collection
    {
        return $this->model->find($ids);
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function allActiveNested(array $where = null, int $paginate = null): mixed
    {
        $query = $this->model->where('active', 1)->orderBy('_lft');
        if ($where) $query = $query->where($where);
        return $paginate ? $query->paginate($paginate) : $query->get()->toTree();
    }

    public function allNested(): Collection
    {
        return $this->model->orderBy('_lft')->get();
    }

    public function get(int $items, array $order)
    {
        if ($order) {
            $this->model = $this->model->orderBy($order['column'], $order['direction']);
        }
        return $this->model->take($items)->get();
    }

    public function getAll()
    {
        return $this->model->get();
    }

    public function resetModel(): static
    {
        $this->model = $this->baseState;

        return $this;
    }

    public function whereHasMax(string $relation, ?callable $callback, string $max_column): ?int
    {
        $this->model = $this->baseState;

        return $this->model->whereHas($relation, $callback)->withCount($relation)->max($max_column);
    }

    public function whereHasMin(string $relation, ?callable $callback, string $min_column): ?int
    {
        return $this->model->whereHas($relation, $callback)->withCount($relation)->min($min_column);
    }

    public function filterAndPaginate(Request $request, $per_page = 36, array $order_by = ['created_at', 'desc'], array $where = [], bool $onlyTrashed = false): mixed
    {
        if ($request->has('filter')) {
            $filters = $request->get('filter');
            if (isset($filters['translate'])) {
                foreach ($filters['translate'] as $column => $value) {
                    $this->model = $this->model->whereTranslationLike($column, "%$value%", App::getLocale());
                }
            }
            if (isset($filters['fullname'])) {
                $this->model = $this->model->whereTranslationLike('first_name', "%" . $filters['fullname'] . "%", App::getLocale())->orWhereTranslationLike('last_name', "%" . $filters['fullname'] . "%", App::getLocale())->orWhereTranslationLike('patronymic', "%" . $filters['fullname'] . "%", App::getLocale());
            }
            if (isset($filters['not_translate'])) {
                foreach ($filters['not_translate'] as $column => $value) {
                    if (!is_null($value)) {
                        $this->model = $this->model->where($column, 'like', "%$value%");
                    }
                }
            }
            if (isset($filters['like'])) {
                foreach ($filters['like'] as $column => $value) {
                    if (!is_null($value)) {
                        $this->model = $this->model->where($column, 'like', "%$value%");
                    }
                }
            }
            if (isset($filters['has'])) {
                foreach ($filters['has'] as $relation => $condition) {
                    if ($condition[array_keys($condition)[0]][0] && $condition[array_keys($condition)[0]][0] !== 'null') {
                        $this->model = $this->model->whereHas($relation, function ($query) use ($relation, $condition) {
                            $query->whereIn($relation . '.' . array_keys($condition)[0], $condition[array_keys($condition)[0]]);
                        });
                    } elseif ($condition[array_keys($condition)[0]][0] === 'null') {
                        $this->model = $this->model->doesntHave($relation);
                    }
                }
            }
            if (isset($filters['date'])) {
                foreach ($filters['date'] as $column => $value) {
                    if (!is_null($value)) {
                        $value = date('Y-m-d', strtotime($value));
                        if (str_starts_with($column, 'min_')) {
                            $column = str_replace('min_', '', $column);
                            $this->model = $this->model->where(function ($query) use ($value, $column) {
                                $query->where($column, '>=', $value)->orWhere('end_date', '>=', $value);
                            });
                        } elseif (str_starts_with($column, 'max_')) {
                            $column = str_replace('max_', '', $column);
                            $this->model = $this->model->where($column, '<=', $value);
                        } else {
                            $this->model = $this->model->where($column, 'like', "%$value%");
                        }
                    }
                }
            }
        }
        if ($where) {
            $this->model = $this->model->where($where);
        }
        if ($onlyTrashed) {
            $this->model = $this->model->onlyTrashed();
        }
        $result = $this->model->orderBy(...$order_by)->paginate($per_page)->withQueryString();
        $this->model = $this->baseState;
        return $result;
    }

    public function where(array $where, array $order_by = ['created_at', 'desc']): mixed
    {
        return $this->model->where($where)->orderBy(...$order_by)->get();
    }

    public function whereTranslationLike(array $where, array $order_by = ['created_at', 'desc']): mixed
    {
        return $this->model->whereTranslationLike(...$where)->orderBy(...$order_by)->get();
    }

    public function whereHas(string $relation, ?callable $callback, bool $onlyActive = false): static
    {
        $this->model = $this->model->whereHas($relation, $callback)->when($onlyActive, function ($query) {
            $query->where('active', 1);
        })->withCount([$relation => $callback]);
        return $this;
    }

    public function whereIn(string $value, array $where): mixed
    {
        return $this->model->whereIn($value, $where)->get();
    }

    public function whereNotIn(string $value, array $where): mixed
    {
        return $this->model->whereNotIn($value, $where)->get();
    }

    public function whereFirst(array $where): mixed
    {
        return $this->model->where($where)->first();
    }

    public function findOrFail($id): ?Model
    {
        return $this->model->findOrFail($id);
    }

    public function allActive(int $paginate = null): mixed
    {
        $this->model = $this->model->where('active', 1);
        return $this->model->get();
    }

    public function allOrdered(int $paginate = null): mixed
    {
        $this->model = $this->model->where('active', 1)->ordered();
        return $this->model->get();
    }

    public function allOrderedBy(array $orderBy): mixed
    {
        return $this->model->orderBy(...$orderBy)->get();
    }

    public function allActiveOrderedBy(array $orderBy): mixed
    {
        return $this->model->where('active', true)->orderBy(...$orderBy)->get();
    }

    public function activeOrderedBy(array $order_by, ?array $where = null): mixed
    {
        $query = $this->model->where('active', 1);
        if ($where) $query = $query->where($where);
        return $query->orderBy(...$order_by)->get();
    }

    public function activeOrderedByTranslation(array $order_by, ?array $where = null): mixed
    {
        $query = $this->model->where('active', 1);
        if ($where) $query = $query->where($where);
        return $query->orderByTranslation(...$order_by)->get();
    }

    public function allOrderedByTranslation(array $orderBy, ?array $where = null): mixed
    {
        $query = $this->model;
        if ($where) $query = $query->where($where);
        return $query->orderByTranslation(...$orderBy)->get();
    }

    public function sortItemsAndSave(array $items): bool
    {
        $success = true;
        foreach ($items as $index => $id) {
            if (!$this->model->where('id', $id)->update(['order_column' => (1 + $index)])) {
                $success = false;
            }
        }
        return $success;
    }

    public function reorder(object $request): bool
    {
        if ($request->has('prev')) {
            $node = $this->model->find($request->input('node'));
            if ($request->has('prev') && $request->input('prev')) {
                $neighbor = $this->model->find($request->input('prev'));
                return $this->insertAfterNode($node, $neighbor);
            }
            if ($request->has('parent') && $request->input('parent')) {
                $parent = $this->model->find($request->input('parent'));
                return $this->prepend($parent, $node);
            }
            if ($request->has('next') && $request->input('next')) {
                $neighbor = $this->model->find($request->input('next'));
                return $this->insertBeforeNode($node, $neighbor);
            }
        }
        return true;
    }

    public function insertAfterNode(object $node, $neighbor): mixed
    {
        return $node->insertAfterNode($neighbor);
    }

    public function prepend(object $parent, $node): mixed
    {
        return $parent->prependNode($node);
    }

    public function insertBeforeNode(object $node, $neighbor): mixed
    {
        return $node->insertBeforeNode($neighbor);
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
                        $q->whereTranslationLike('title', "%$word%", App::getLocale())->orWhereTranslationLike('description', "%$word%", App::getLocale());
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

    public function getCombinations(Request $request): mixed
    {
        $search_str = $request->get('query');
        $search_words = explode(' ', $search_str);

        $string = $search_str;
        $exp = explode(' ', $search_str);
        $new = [];
        foreach ($exp as $key => $ex) {
            trim($exp[$key]);
            $ex = trim($ex);
            if (mb_strlen($ex) < 3) {
                unset($exp[$key]);
            } else {
                $new[] = $ex;
            }
        }
        $exp = $new;
        if (!count($exp)) return [];
        $count = count($exp);
        $array = [];
        for ($i = 0; $i < $this->cisla($string); $i++) {
            $array[] = sprintf("%0" . $count . "d", decbin($i + 1));
        }

        foreach ($array as $key => $value) {
            for ($i = 0; $i < strlen($value); $i++) {
                if ($value[$i] == 1) {
                    $massive[$key][] = $exp[$i];
                }
            }
        }
        array_multisort(array_map('count', $massive), SORT_DESC, $massive);

        return $massive;
    }

    public function cisla($string): int
    {
        $used_combinations = [];
        $exp = explode(' ', $string);
        $exp = array_slice($exp, 0, 3);
        $new = [];
        foreach ($exp as $key => $ex) {
            trim($exp[$key]);
            $ex = trim($ex);
            if (strlen($ex) < 3) {
                unset($exp[$key]);
            } else {
                $new[] = $ex;
            }
        }
        $count = count($new);
        $stepen = 2 ** $count;
        return $stepen - 1;
    }

    public function escapefile_url($url): string
    {
        $parts = parse_url($url);
        $path_parts = array_map('rawurldecode', explode('/', $parts['path']));

        return
            $parts['scheme'] . '://' .
            $parts['host'] .
            implode('/', array_map('rawurlencode', $path_parts)) .
            (isset($parts['query']) ? '?'.rawurldecode($parts['query']) : '')
            ;
    }

    public function handleMedia(Model $model, array $data, ?string $collection_name = null): void
    {
        if (isset($data['preview']) || isset($data['preview_url'])) $model->clearMediaCollection($collection_name ?? 'preview');
        if (isset($data['preview'])) $model->addMedia($data['preview'])->toMediaCollection($collection_name ?? 'preview');
        if (isset($data['preview_url'])) $model->addMediaFromUrl($this->escapefile_url($data["preview_url"]))->toMediaCollection($collection_name ?? 'preview');
        if (isset($data['small_preview']) || isset($data['small_preview_url'])) $model->clearMediaCollection($collection_name ?? 'small_preview');
        if (isset($data['small_preview'])) $model->addMedia($data['small_preview'])->toMediaCollection($collection_name ?? 'small_preview');
        if (isset($data['small_preview_url'])) $model->addMediaFromUrl($this->escapefile_url($data["small_preview_url"]))->toMediaCollection($collection_name ?? 'small_preview');
        if (isset($data['banner_preview']) || isset($data['banner_preview_url'])) $model->clearMediaCollection($collection_name ?? 'banner_preview');
        if (isset($data['banner_preview'])) $model->addMedia($data['banner_preview'])->toMediaCollection($collection_name ?? 'banner_preview');
        if (isset($data['banner_preview_url'])) $model->addMediaFromUrl($this->escapefile_url($data["banner_preview_url"]))->toMediaCollection($collection_name ?? 'banner_preview');
        if (isset($data['big_preview']) || isset($data['big_preview_url'])) $model->clearMediaCollection($collection_name ?? 'big_preview');
        if (isset($data['big_preview'])) $model->addMedia($data['big_preview'])->toMediaCollection($collection_name ?? 'big_preview');
        if (isset($data['big_preview_url'])) $model->addMediaFromUrl($this->escapefile_url($data["big_preview_url"]))->toMediaCollection($collection_name ?? 'big_preview');

        if (isset($data['bottom_preview']) || isset($data['bottom_preview_url'])) $model->clearMediaCollection('bottom_preview');
        if (isset($data['bottom_preview'])) $model->addMedia($data['bottom_preview'])->toMediaCollection('bottom_preview');
        if (isset($data['bottom_preview_url'])) $model->addMediaFromUrl($this->escapefile_url($data["bottom_preview_url"]))->toMediaCollection('bottom_preview');
        if (isset($data['tech']) || isset($data['tech_url'])) $model->clearMediaCollection($collection_name ?? 'tech');
        if (isset($data['tech'])) $model->addMedia($data['tech'])->toMediaCollection($collection_name ?? 'tech');
        if (isset($data['tech_url'])) $model->addMediaFromUrl($this->escapefile_url($data["tech_url"]))->toMediaCollection($collection_name ?? 'tech');
        if (isset($data['preview_left']) || isset($data['preview_url_left'])) $model->clearMediaCollection('preview_left');
        if (isset($data['preview_left'])) $model->addMedia($data['preview_left'])->toMediaCollection('preview_left');
        if (isset($data['preview_url_left'])) $model->addMediaFromUrl($this->escapefile_url($data["preview_url_left"]))->toMediaCollection('preview_left');
        if (isset($data['preview_right']) || isset($data['preview_url_right'])) $model->clearMediaCollection('preview_right');
        if (isset($data['preview_right'])) $model->addMedia($data['preview_right'])->toMediaCollection('preview_right');
        if (isset($data['preview_url_right'])) $model->addMediaFromUrl($this->escapefile_url($data["preview_url_right"]))->toMediaCollection('preview_right');
        if (isset($data['preview_center']) || isset($data['preview_url_center'])) $model->clearMediaCollection('preview_center');
        if (isset($data['preview_center'])) $model->addMedia($data['preview_center'])->toMediaCollection('preview_center');
        if (isset($data['preview_url_center'])) $model->addMediaFromUrl($this->escapefile_url($data["preview_url_center"]))->toMediaCollection('preview_center');
        foreach (LaravelLocalization::getLocalesOrder() as $localeCode => $propertiesArray) {
            if (isset($data["preview_$localeCode"]) || isset($data["preview_url_$localeCode"])) $model->clearMediaCollection("preview_$localeCode", 'do_images');
            if (isset($data["preview_$localeCode"])) $model->addMedia($data["preview_$localeCode"])->toMediaCollection("preview_$localeCode", 'do_images');
            if (isset($data["preview_url_$localeCode"])) $model->addMediaFromUrl($this->escapefile_url($data["preview_url_$localeCode"]))->toMediaCollection("preview_$localeCode", 'do_images');
        }
        if (isset($data['delete_images']) && $data['delete_images']) {
            $images = Media::find($data['delete_images']);
            $images->each->delete();
        }
    }

    public function handleGallery(array $data)
    {
        if (isset($data['images']) && $data['images']) {
            foreach ($data['images'] as $order => $id) {
                $this->fileRepository->update($id, ['order_column' => $order]);
            }
        }
    }

    public function update(int $id, array $data): bool
    {
        return $this->find($id)->update($data);
    }

    public function handleCategories(array $data, object $model)
    {
        $categories = [];
        if (isset($data['category_id']) && $data['category_id']) {
            $categories[] = $data['category_id'];
        }

        $model->categories()->sync($categories);
    }

    public function getModel(): mixed
    {
        return $this->model;
    }

}
