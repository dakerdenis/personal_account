<?php

namespace App\Repository\Eloquent;

use App\Models\Manager;
use App\Repository\ManagementRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

class ManagementRepository extends BaseRepository implements ManagementRepositoryInterface
{
    public function __construct(Manager $model)
    {
        parent::__construct($model);
    }


    public function create(array $attributes): Model
    {
        /** @var Manager $manager */
        $manager = $this->model->create($attributes);
        $this->handleMedia($manager, $attributes);

        return $manager;
    }

    public function update(int $id, array $data): bool
    {
        $manager = $this->find($id);
        $this->handleMedia($manager, $data);

        return $manager->update($data);
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
