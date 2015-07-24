<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//\Debugbar::enable();
//SqlDebug::on();

//if (isset($_SERVER['HTTP_REFERER']))
//pr($_SERVER['HTTP_REFERER']);

/*
Blade::extend(function($value) {
	return preg_replace('/\{\?(.+)\?\}/', '<?php ${1} ?>', $value);
});
*/

Route::group(array('prefix'=>'admin', 'before' => 'auth'), function()
{
	//pages
	Route::any('/', 
		array('as'=>'pagesDefaultAdmin', 'uses'=>'PagesAdminController@def'));
	Route::any('/pages/edit/{id}',  
		array('as'=>'pagesEditAdmin', 'uses'=>'PagesAdminController@edit'));
	Route::any('/pages/create',
		array('as'=>'pagesCreateAdmin', 'uses'=>'PagesAdminController@create'));
	Route::any('/pages/active',
		array('as'=>'pagesActiveAdmin', 'uses'=>'PagesAdminController@active'));
	Route::any('/pages/position',
		array('as'=>'pagesPositionAdmin', 'uses'=>'PagesAdminController@position'));
	Route::any('/pages/delete',
		array('as'=>'pagesDeleteAdmin', 'uses'=>'PagesAdminController@delete'));
//	Route::any('/pages/tree',
//		array('as'=>'pagesTreeAdmin', 'uses'=>'PagesAdminController@tree'));
	
	// множественное прикрепление файлов
	Route::any('/pages/upload/{id}',
		array('as'=>'pagesUploadAdmin', 'uses'=>'PagesAdminController@upload'));
	Route::any('/pages/upload_delete',
		array('as'=>'pagesUploadDelAdmin', 'uses'=>'PagesAdminController@upload_delete'));

	Route::any('/pages/test',
		array('as'=>'pagesTestAdmin', 'uses'=>'PagesAdminController@test'));
	
	Route::any('/info',
		array('as'=>'InfoDefaultAdmin', 'uses'=>'InfoAdminController@def'));
	
	Route::any('/info/php',
		array('as'=>'InfoPhpAdmin', 'uses'=>'InfoAdminController@php'));
	
	
	$arr = array('users');
	
	foreach ($arr as $module) {
		Route::any('/'.$module,
			array('as'=>$module.'DefaultAdmin', 'uses'=>ucfirst($module).'AdminController@def'));
		Route::any('/'.$module.'/edit/{id}',
			array('as'=>$module.'EditAdmin',    'uses'=>ucfirst($module).'AdminController@edit'));
		Route::any('/'.$module.'/create',
			array('as'=>$module.'CreateAdmin',  'uses'=>ucfirst($module).'AdminController@create'));
		Route::any('/'.$module.'/delete',
			array('as'=>$module.'DeleteAdmin',  'uses'=>ucfirst($module).'AdminController@delete'));
		Route::any('/'.$module.'/active',
			array('as'=>$module.'ActiveAdmin',  'uses'=>ucfirst($module).'AdminController@active'));
	}

	
});

Route::group(array('before' => 'auth'), function()
{
	Route::any('/users/edit', array('as' => 'users.edit', 'uses' => 'UsersController@edit'));
	Route::any('/users/soc/disconnect/{provider}', array('as' => 'users.soc.disconnect', 'uses' => 'UsersController@disconnect'));
});

Route::any('/users/login', array('as' => 'login', 'uses' => 'UsersController@login'));
Route::any('/users/logout', array('as' => 'logout', 'uses' => 'UsersController@logout'));
Route::any('/users/register', array('as' => 'users.register', 'uses' => 'UsersController@register'));
Route::any('/users/soc/{provider}', array('as' => 'users.soc', 'uses' => 'UsersController@soc'));

Route::get('/test', 'TestController@def');
Route::get('/', 'PagesController@def');

Route::get('/pages/{slug}', 'PagesController@pages');