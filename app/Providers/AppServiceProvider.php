<?php

namespace App\Providers;

use App\Services\CustomLengthAwarePaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Paginator::useBootstrap();
        app()->bind(LengthAwarePaginator::class, CustomLengthAwarePaginator::class);
        Collection::macro('paginate', function ($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });

        Collection::macro('alphabetSort', function ($field_name = 'title') {
            $alphabets = [
                'az' => mb_str_split("123456789abcçdeəfgğhxıijkqlmnoöprsştuüvyz"),
                'ru' => mb_str_split("123456789абвгдеёжзийклмнопрстуфхцчшщъыьэюя"),
            ];
            if (App::getLocale() !== 'en') {
                $order = $alphabets[App::getLocale()];
                return $this->sort(function ($a, $b) use ($order, $field_name) {
                    if (is_numeric($a->{$field_name}) && is_numeric($b->{$field_name}))
                        return $a->{$field_name} - $b->{$field_name};
                    $posA = array_search(mb_substr(mb_strtolower($a->{$field_name}), 0, 1), $order);
                    $posB = array_search(mb_substr(mb_strtolower($b->{$field_name}), 0, 1), $order);
                    return $posA - $posB;
                });
            }
            return $this;
        });
    }
}
