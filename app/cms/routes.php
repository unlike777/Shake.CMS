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

Route::group(array('prefix'=>'admin', 'before' => 'admin'), function()
{
	
	//pages additional
	Route::any('/pages/position',
		array('as'=>'pagesPositionAdmin', 'uses'=>'PagesAdminController@position'));
//	Route::any('/pages/tree',
//		array('as'=>'pagesTreeAdmin', 'uses'=>'PagesAdminController@tree'));

	Route::any('/pages/test',
		array('as'=>'pagesTestAdmin', 'uses'=>'PagesAdminController@test'));
	
	Route::any('/info',
		array('as'=>'infoDefaultAdmin', 'uses'=>'InfoAdminController@def'));
	
	Route::any('/info/php',
		array('as'=>'infoPhpAdmin', 'uses'=>'InfoAdminController@php'));
	
	
	$arr = array('pages', 'users', 'settings');
	
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
		
		// множественное прикрепление файлов
		Route::any('/'.$module.'/upload/{id}',
			array('as'=>$module.'UploadAdmin', 'uses'=>ucfirst($module).'AdminController@upload'));
		Route::any('/'.$module.'/upload_delete',
			array('as'=>$module.'UploadDelAdmin', 'uses'=>ucfirst($module).'AdminController@upload_delete'));
		
		// Уникальные поля
		Route::any('/'.$module.'/field_create/{parent_id}',
			array('as'=>$module.'UploadAdmin', 'uses'=>ucfirst($module).'AdminController@field_create'));
		Route::any('/'.$module.'/field_update/{id}',
			array('as'=>$module.'UploadAdmin', 'uses'=>ucfirst($module).'AdminController@field_update'));
		Route::any('/'.$module.'/field_delete/{id}',
			array('as'=>$module.'UploadAdmin', 'uses'=>ucfirst($module).'AdminController@field_delete'));
	}
	
});