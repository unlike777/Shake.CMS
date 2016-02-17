##Shake.CMS Copyright 2015

###Admin dashboard kit base on laravel 4.2

admin access  
login: test@test.ru  
password: admins 

###Установка

1. git clone https://github.com/unlike777/Shake.CMS.git .
2. composer update
3. настроить конфиг для БД
4. php artisan migrate
5. php artisan db:seed (тестовые данные)

PS
+ чтобы создать или сбросить только страницы php artisan db:seed --class=PagesSeeder
+ чтобы создать или сбросить только пользователей php artisan db:seed --class=UsersSeeder

Или экспортировать БД из **laravel.sql**

###Описание

Набор готовых классов для реализации админки на laravel  
Полностью избавляет вас от рутины создавать стандартные для каждого сайта модули:
* Структура страниц
* Пользователи
* Минитексты
* AJAX загрузка файлов
* Уникальные поля

Так же вы с легкостью сможете переписать или дополнить имеющиеся модули для админки  
Зачем тратить время на создание админки, когда лучше сконцентрироваться на бизнес логике проекта

Максимально не тронута структура самого фреймворка

Верстка админки основана на Twitter Bootstrap
