<?php

namespace App\Repository\Eloquent;

use App\Models\Slider;
use App\Repository\SliderRepositoryInterface;

class SliderRepository extends BaseRepository implements SliderRepositoryInterface
{

    /**
     * AttributeRepository constructor.
     *
     * @param Slider $model
     */
    public function __construct(Slider $model)
    {
        parent::__construct($model);
    }

    public function getSlides(string $machine_name)
    {
        $slider = $this->model->where('machine_name', $machine_name)->first();
        if ($slider) {
            return $slider->slides()->ordered()->get();
        }
        return null;
    }

}
