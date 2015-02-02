Laravel Cyrillic Slug
========

[![Latest Stable Version](https://poser.pugx.org/ivanlemeshev/laravel-cyrillic-slug/v/stable.svg)](https://packagist.org/packages/ivanlemeshev/laravel-cyrillic-slug) [![Total Downloads](https://poser.pugx.org/ivanlemeshev/laravel-cyrillic-slug/downloads.svg)](https://packagist.org/packages/ivanlemeshev/laravel-cyrillic-slug) [![Latest Unstable Version](https://poser.pugx.org/ivanlemeshev/laravel-cyrillic-slug/v/unstable.svg)](https://packagist.org/packages/ivanlemeshev/laravel-cyrillic-slug) [![License](https://poser.pugx.org/ivanlemeshev/laravel-cyrillic-slug/license.svg)](https://packagist.org/packages/ivanlemeshev/laravel-cyrillic-slug)

Supported Alphabets
-------
* Russian
* Kazakh
* Ukrainian

Installation
-------
You should install this package through Composer.

Edit your project's `composer.json` file to require `ivanlemeshev/laravel-cyrillic-slug`.

    "require": {
        "ivanlemeshev/laravel-cyrillic-slug": "dev-master"
    },

Next, update Composer from the Terminal:
    `composer update`

Once this operation completes, the final step is to add the service provider.
Open `app/config/app.php`, and add a new item to the providers array.

  `'Ivanlemeshev\LaravelCyrillicSlug\SlugServiceProvider',`

And add a new item to the aliases array.

  `'Slug' => 'Ivanlemeshev\LaravelCyrillicSlug\Facades\Slug',`

Usage
-------
Call of the method: `Slug::make($text)`

Call of the method with specific separator: `Slug::make($text, '_')`.

License
-------

The MIT License (MIT)

Copyright (c) 2014 Ivan Lemeshev

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
