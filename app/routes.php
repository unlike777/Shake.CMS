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
//\Debugbar::disable();
//SqlDebug::on();

/*
Blade::extend(function($value) {
	return preg_replace('/\{\?(.+)\?\}/', '<?php ${1} ?>', $value);
});
*/

Route::group(array('before' => 'auth'), function()
{
	Route::any('/users/edit', array('as' => 'users.edit', 'uses' => 'UsersController@edit'));
	Route::any('/auth/soc/disconnect/{provider}', array('as' => 'auth.soc.disconnect', 'uses' => 'AuthController@disconnect'));
});

Route::controller('password', 'RemindersController');

Route::any('/login', array('as' => 'login', 'uses' => 'AuthController@login'));
Route::any('/logout', array('as' => 'logout', 'uses' => 'AuthController@logout'));
Route::any('/register/{soc?}', array('as' => 'register', 'uses' => 'AuthController@register'));
Route::any('/auth/soc/{provider}', array('as' => 'auth.soc', 'uses' => 'AuthController@soc'));

Route::get('/test', 'TestController@def');
Route::get('/', 'PagesController@def');

Route::get('/pages/{slug}', 'PagesController@pages');
