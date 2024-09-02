<?php

namespace App\Repository\Eloquent;

use App\Models\Slide;
use App\Models\SlideLink;
use App\Repository\SlideRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class SlideRepository extends BaseRepository implements SlideRepositoryInterface
{

    /**
     * SlideRepository constructor.
     *
     * @param Slide $model
     */
    public function __construct(Slide $model)
    {
        parent::__construct($model);
    }

    public function create(array $attributes): Model
    {
        $slider_id = $attributes['slider_id'];
        $order_column = 1;
        if (isset($attributes['delete_slides']) && $attributes['delete_slides']) {
            foreach ($attributes['delete_slides'] as $slideToDelete) {
                $this->delete($slideToDelete);
            }
        }
        if (isset($attributes['delete_links']) && $attributes['delete_links']) {
            foreach ($attributes['delete_links'] as $slideToDelete) {
                SlideLink::where('id', $slideToDelete)->delete();
            }
        }

        foreach ($attributes['slides'] ?? [] as $id => $data) {
            $slide = $this->model->updateOrCreate(
                [
                    'slider_id' => $slider_id,
                    'id' => $id,
                ],
                $data + ['slider_id' => $slider_id, 'order_column' => $order_column],
            );
            $order_column++;
            $this->handleMedia($slide, $data);
            $this->handleLinks($slide, $data);
        }

        return $slide;
    }



    public function handleLinks(Slide $slide, array $data): void
    {
        if (isset($data['links'])) {
            $order_column = 0;
            foreach ($data['links'] as $id => $block) {
                $slide->slideLinks()->updateOrCreate(['id' => $id], $block + ['order_column' => $order_column]);
                $order_column++;
            }
        }
    }

}
