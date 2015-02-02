<?php

View::composer('admin.widgets.mainMenu.*', function($view) {
	$menu = array(
		array('name' => 'Страницы', 'url' => '/admin', 'route' => 'PagesAdminController', 'glyph' => 'glyphicon-th-list'),
		array('name' => 'Пользователи', 'url' => '/admin/users', 'route' => 'UsersAdminController', 'glyph' => 'glyphicon-user'),
		array('name' => 'Настройки', 'url' => '/admin/settings', 'route' => 'SettingsAdminController', 'glyph' => 'glyphicon-wrench'),
	);

	$route = Route::currentRouteAction();
	$route = explode('@', $route);
	$route = $route[0];
	
	$view->with(array(
		'menu' => $menu,
		'route' => $route,
	));
});