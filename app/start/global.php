<?php

function pr($p) 
{
	echo "<pre>"; var_export($p); echo "</pre>";
}

function uncache($url) 
{
	$url =  '/' . $url;
	$url = str_replace('//', '/', $url);
	$full_path = public_path() . $url;
	
	$pref = 'not_found';
	if(file_exists($full_path)){
		$pref = filemtime($full_path);
	}
	
	return $url . '?' . $pref;
}

/**
 * добавляет к текущему запросу дополнительные параметры
 * @param $arr
 * @return string
 */
function add_to_query($arr) {
	return http_build_query(array_merge(Input::query(), $arr));
}

/**
 * удаляет параметры у текущего запроса
 * @param $arr
 * @return string
 */
function del_from_query($arr) {
	$tmp = Input::query();
	foreach ($arr as $val) {
		if (isset($tmp[$val])) {
			unset($tmp[$val]);
		}
	}
	return http_build_query($tmp);
}


/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/controllers/admin',
	app_path().'/models',
	app_path().'/database/seeds',
	app_path().'/libs',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

Log::useFiles(storage_path().'/logs/laravel.log');

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Exception $exception, $code)
{
	Log::error($exception);
	
	if (!Config::get('app.debug')) {
		return Response::view('errors.default', array('code' => $code), $code);
	}
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/

App::down(function()
{
	return Response::make("Be right back!", 503);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/filters.php';

require app_path().'/composers.php';
