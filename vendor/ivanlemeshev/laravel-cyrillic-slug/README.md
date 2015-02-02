Laravel Cyrillic Slug
========

[![Latest Stable Version](https://poser.pugx.org/ivanlemeshev/laravel-cyrillic-slug/v/stable.svg)](https://packagist.org/packages/ivanlemeshev/laravel-cyrillic-slug) [![Total Downloads](https://poser.pugx.org/ivanlemeshev/laravel-cyrillic-slug/downloads.svg)](https://packagist.org/packages/ivanlemeshev/laravel-cyrillic-slug) [![Latest Unstable Version](https://poser.pugx.org/ivanlemeshev/laravel-cyrillic-slug/v/unstable.svg)](https://packagist.org/packages/ivanlemeshev/laravel-cyrillic-slug) [![License](https://poser.pugx.org/ivanlemeshev/laravel-cyrillic-slug/license.svg)](https://packagist.org/packages/ivanlemeshev/laravel-cyrillic-slug)

Поддерживаемые алфавиты
-------
* Русский
* Казахский
* Украинский

Установка
-------
Этот пакет нужно установить через [Composer](https://getcomposer.org/).

Добавьте в файл `composer.json` вашего проекта в разделе `require` строку
`ivanlemeshev/laravel-cyrillic-slug`.

    "require": {
        "ivanlemeshev/laravel-cyrillic-slug": "dev-master"
    },

Затем в терминале выполните команду:
    `composer update`

После этого, добавьте сервис-провайдер.
Откройте `app/config/app.php`, и добавьте новый элемет в массив провайдеров.

  `'Ivanlemeshev\LaravelCyrillicSlug\SlugServiceProvider',`

И добавьте новый элемент в массив алиасов.

  `'Slug' => 'Ivanlemeshev\LaravelCyrillicSlug\Facades\Slug',`

Использование
-------
Вызов метода: `Slug::make($text)`

Вызов метода с указанием разделителя(по умолчанию "-"): `Slug::make($text, '_')`.

Лицензия MIT
-------

Copyright (c) 2014 Иван Лемешев

Данная лицензия разрешает, безвозмездно, лицам,получившим копию данного
программного обеспечения и сопутствующей документации (в дальнейшем именуемыми
"Программное Обеспечение"), использовать Программное Обеспечение без ограничений,
включая неограниченное право на использование, копирование, изменение,
объединение, публикацию, распространение, сублицензирование и/или продажу копий
Программного Обеспечения, также как и лицам, которым предоставляется данное
Программное Обеспечение, при соблюдении следующих условий:

Вышеупомянутый копирайт и данные условия должны быть включены во все копии или
значимые части данного Программного Обеспечения.

ДАННОЕ ПРОГРАММНОЕ ОБЕСПЕЧЕНИЕ ПРЕДОСТАВЛЯЕТСЯ «КАК ЕСТЬ», БЕЗ ЛЮБОГО ВИДА
ГАРАНТИЙ, ЯВНО ВЫРАЖЕННЫХ ИЛИ ПОДРАЗУМЕВАЕМЫХ, ВКЛЮЧАЯ, НО НЕ ОГРАНИЧИВАЯСЬ
ГАРАНТИЯМИ ТОВАРНОЙ ПРИГОДНОСТИ, СООТВЕТСТВИЯ ПО ЕГО КОНКРЕТНОМУ НАЗНАЧЕНИЮ И
НЕНАРУШЕНИЯ ПРАВ. НИ В КАКОМ СЛУЧАЕ АВТОРЫ ИЛИ ПРАВООБЛАДАТЕЛИ НЕ НЕСУТ
ОТВЕТСТВЕННОСТИ ПО ИСКАМ О ВОЗМЕЩЕНИИ УЩЕРБА, УБЫТКОВ ИЛИ ДРУГИХ ТРЕБОВАНИЙ
ПО ДЕЙСТВУЮЩИМ КОНТРАКТАМ, ДЕЛИКТАМ ИЛИ ИНОМУ, ВОЗНИКШИМ ИЗ, ИМЕЮЩИМ ПРИЧИНОЙ
ИЛИ СВЯЗАННЫМ С ПРОГРАММНЫМ ОБЕСПЕЧЕНИЕМ ИЛИ ИСПОЛЬЗОВАНИЕМ ПРОГРАММНОГО
ОБЕСПЕЧЕНИЯ ИЛИ ИНЫМИ ДЕЙСТВИЯМИ С ПРОГРАММНЫМ ОБЕСПЕЧЕНИЕМ.

