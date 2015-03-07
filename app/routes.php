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

//DB::listen(function($query, $bindings, $time)
//{
//	
//	foreach ($bindings as $i => $binding)
//	{
//		if ($binding instanceof \DateTime)
//		{
//			$bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
//		}
//		else if (is_string($binding))
//		{
//			$bindings[$i] = "'$binding'";
//		}
//	}
//
//	$query = str_replace(array('%', '?'), array('%%', '%s'), $query);
//	$query = vsprintf($query, $bindings);
//
//	SqlDebug::add($query, $time/1000);
//});

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




Route::get('/test', 'TestController@def');
Route::get('/', 'PagesController@def');

Route::any('/login', 'UsersController@login');
Route::any('/logout', 'UsersController@logout');

Route::get('/pages/{slug}', 'PagesController@pages');