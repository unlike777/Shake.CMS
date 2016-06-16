<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

Route::filter('admin', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	} else {
		
		$user = Auth::getUser();
		
		if ($user->group != 1) {
			return Response::make('Permission denied', 401);
		}
		else
		{
			session_start();
			$_SESSION['is_admin'] = 1;
		}
		
	}
});
