<?php

View::composer('admin.widgets.mainMenu.*', function($view) {
	$menu = array(
		array(
			'group' => 'Структура',
			'items' => array(
				array('name' => 'Страницы', 'url' => '/admin', 'route' => 'PagesAdminController', 'glyph' => 'glyphicon-th-list'),
			),
		),
		array(
			'group' => 'Системные',
			'items' => array(
				array('name' => 'Пользователи', 'url' => '/admin/users', 'route' => 'UsersAdminController', 'glyph' => 'glyphicon-user'),
				array('name' => 'Настройки', 'url' => '/admin/settings', 'route' => 'SettingsAdminController', 'glyph' => 'glyphicon-wrench'),
				array('name' => 'Инфо о сервере', 'url' => '/admin/info', 'route' => 'InfoAdminController', 'glyph' => 'glyphicon-info-sign'),
			),
		),
	);

	$route = Route::currentRouteAction();
	$route = explode('@', $route);
	$route = $route[0];
	
	$view->with(array(
		'menu' => $menu,
		'route' => $route,
	));
});