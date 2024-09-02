<?php

namespace App\Repository\Eloquent;

use App\Models\FaqEntity;
use App\Models\Partner;
use App\Repository\FaqRepositoryInterface;
use App\Repository\PartnerRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PartnerRepository extends BaseRepository implements PartnerRepositoryInterface
{
    public function __construct(Partner $model)
    {
        parent::__construct($model);
    }

    public function create(array $attributes): Model
    {
        if (isset($attributes['review'])) {
            $attributes['review'] = $attributes['review']->storeAs(
                '/uploaded_reviews/' . Str::random(4),
                Str::transliterate($attributes['review']->getClientOriginalName()),
                'public'
            );
        }
        $partner = $this->model->create($attributes);
        $this->handleMedia($partner, $attributes);

        return $partner;
    }

    public function update(int $id, array $data): bool
    {
        $partner = $this->model->findOrFail($id);
        if (isset($data['review'])) {
            $data['review'] = $data['review']->storeAs(
                '/uploaded_reviews/' . Str::random(4),
                Str::transliterate($data['review']->getClientOriginalName()),
                'public'
            );
        }
        $partner->update($data);
        $this->handleMedia($partner, $data);

        return true;
    }

    public function forBlock()
    {
        return $this->model->where('active', true)->where('show_in_block', true)->orderBy('_lft')->get();
    }
}
