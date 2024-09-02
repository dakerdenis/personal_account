<?php

namespace App\Repository\Eloquent;

use App\Models\Repeatable;
use App\Repository\RepeatableRepositoryInterface;

class RepeatableRepository extends BaseRepository implements RepeatableRepositoryInterface
{
    private ?string $media_collection_name = null;

    public function __construct(Repeatable $model)
    {
        parent::__construct($model);
    }

    public function handleRepeatable(array $data, object $reference)
    {
        if (isset($data['media_collection_name']) && $data['media_collection_name']) $this->media_collection_name = $data['media_collection_name'];
        if (isset($data['delete_repeatables']) && $data['delete_repeatables']) {
            foreach ($data['delete_repeatables'] as $repeatable) {
                $this->find($repeatable)?->delete();
            }
        }
        if (isset($data['repeatable']) && $data['repeatable']) {
            $order_column = 0;
            foreach ($data['repeatable'] as $id => $repeatable) {
                $this->updateOrCreateOnReference($id, $repeatable + ['order_column' => $order_column], $reference);
                $order_column++;
            }
        }
    }

    public function updateOrCreateOnReference(int|string $id, array $attributes, object $reference)
    {
        $repeatable = $reference->repeatables()->updateOrCreate(['id' => $id], $attributes);
        $this->handleMedia($repeatable, $attributes, $this->media_collection_name);
    }

}
