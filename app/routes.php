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

/*
Blade::extend(function($value) {
	return preg_replace('/\{\?(.+)\?\}/', '<?php ${1} ?>', $value);
});
*/

Route::group(array('before' => 'auth'), function()
{
	Route::any('/users/edit', array('as' => 'users.edit', 'uses' => 'UsersController@edit'));
	Route::any('/users/soc/disconnect/{provider}', array('as' => 'users.soc.disconnect', 'uses' => 'UsersController@disconnect'));
});

Route::controller('password', 'RemindersController');

Route::any('/login', array('as' => 'login', 'uses' => 'UsersController@login'));
Route::any('/logout', array('as' => 'logout', 'uses' => 'UsersController@logout'));
Route::any('/register', array('as' => 'register', 'uses' => 'UsersController@register'));
Route::any('/users/soc/{provider}', array('as' => 'users.soc', 'uses' => 'UsersController@soc'));

Route::get('/test', 'TestController@def');
Route::get('/', 'PagesController@def');

Route::get('/pages/{slug}', 'PagesController@pages');