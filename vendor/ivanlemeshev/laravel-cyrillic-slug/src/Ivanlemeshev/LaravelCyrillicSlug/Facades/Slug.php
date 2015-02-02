<?php namespace Ivanlemeshev\LaravelCyrillicSlug\Facades;

use Illuminate\Support\Facades\Facade;

class Slug extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-cyrillic-slug';
    }

}
