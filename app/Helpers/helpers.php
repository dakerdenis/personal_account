<?php
function customIndexUrl(): string
{
    if (app()->getLocale() !== config('app.default_locale')) {
        return route('index', app()->getLocale());
    }

    return route('index');
}
function forceIndexNoLocale(): string
{
    return route('index');
}
