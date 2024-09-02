<?php

namespace App\Repository\Eloquent;

use App\Models\StaticPage;
use App\Repository\StaticPageRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class StaticPageRepository extends BaseRepository implements StaticPageRepositoryInterface
{

    public function __construct(
        StaticPage $model,
    ) {
        parent::__construct($model);
    }

    public function create(array $attributes): Model
    {
        $static_page = $this->model->create($attributes);
        $this->handleSpecialOffers($static_page, $attributes);
        $this->handleUsefulLinks($static_page, $attributes);

        return $static_page;
    }

    public function handleSpecialOffers(StaticPage $staticPage, array &$data)
    {
        if ($data['files'] ?? false) {
            $articles = [];
            foreach ($data['files'] as $order => $article) {
                $articles[$article] = ['order' => $order];
            }
            $staticPage->files()->sync($articles);
            unset($data['files']);
        }
    }

    public function handleUsefulLinks(StaticPage $staticPage, array &$data)
    {
        if ($data['useful_links'] ?? false) {
            $links = [];
            foreach ($data['useful_links'] as $order => $link) {
                $links[$link] = ['order' => $order];
            }
            $staticPage->usefulLinks()->sync($links);
            unset($data['useful_links']);
        }
    }

    public function update(int $id, array $data): bool
    {
        $static_page = $this->find($id);

        $this->handleUsefulLinks($static_page, $data);
        $this->handleSpecialOffers($static_page, $data);

        return $static_page->update($data);
    }
}
