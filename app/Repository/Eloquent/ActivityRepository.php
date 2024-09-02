<?php

namespace App\Repository\Eloquent;

use App\Repository\ActivityRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Contracts\Activity as ActivityContract;
use Spatie\Activitylog\Models\Activity;

class ActivityRepository extends BaseRepository implements ActivityRepositoryInterface
{
    public function __construct(Activity $model)
    {
        parent::__construct($model);
    }

    public function log(string $log_name, Model $model, array $properties = [], string $description = '', object $causer = null): ?ActivityContract
    {
        return activity($log_name)->on($model)->withProperties($properties)->log($description);
    }

}
