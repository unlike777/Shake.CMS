<?php

function pr($p) 
{
	echo "<pre>";
		if (is_array($p) || is_object($p)) {
			print_r($p);
		} else if ( is_bool($p) || empty($p) || (is_string($p) && trim($p) == '') ) {
			var_export($p);
		} else {
			print_r($p);
		}
	echo "</pre>";
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

/**
 * Вернет слово в правильном склонении в зависимости от кол-ва
 * @param $number
 * @param $one
 * @param $two
 * @param $five
 * @return mixed
 */
function plurar($number, $one, $two , $five) {
	if (($number - $number % 10 ) % 100 != 10) {
		if ($number % 10 == 1 ) {
			$result = $one;
		} elseif ( ($number % 10 >= 2 ) && ($number % 10 <= 4) ) {
			$result = $two;
		} else {
			$result = $five;
		}
	} else {
		$result = $five;
	}
	return $result ;
}

/**
 * Добавит к названиям таблиц префиксы
 * @param $str
 * @return mixed
 */
function table_prefix($str) {

	preg_match_all('/([A-z0-9]+\.[A-z0-9]+)/ui', $str, $arr);
	$prefix = DB::getTablePrefix();

	if (isset($arr[0])) {
		foreach ($arr[0] as $item) {
			if (!is_numeric($item)) {
				$tmp = explode('.', trim($item));
				if (count($tmp) == 2) {
					$new = '`'.$prefix.$tmp[0].'`.`'.$tmp[1].'`';
					$str = str_replace($item, $new, $str);
				}
			}
		}
	}

	return $str;
}

/**
 * Выведет информацию о времени существования сайта
 * @param $start_year
 * @return string
 */
function siteExist($start_year) {
	return (date('Y') <= $start_year) ? $start_year : $start_year.' — '.date('Y');
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

App::finish(function() {
	SqlDebug::out();
});

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
