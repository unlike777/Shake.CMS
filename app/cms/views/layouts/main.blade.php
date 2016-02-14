<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Shake.CMS</title>

	<link type="text/css" rel="stylesheet" href="{{ uncache('cms/bootstrap/css/bootstrap.css') }}">
	<link type="text/css" rel="stylesheet" href="{{ uncache('cms/bootstrap/css/bootstrap-theme.css') }}">
	<link type="text/css" rel="stylesheet" href="{{ uncache('cms/libs/nestable/style.css') }}">
	<link type="text/css" rel="stylesheet" href="{{ uncache('cms/bootstrap/css/bootstrap-datetimepicker.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ uncache('cms/libs/fancybox/jquery.fancybox.css') }}">
	
	<link type="text/css" rel="stylesheet" href="{{ uncache('cms/style.css') }}">
	
	<link rel="SHORTCUT ICON" href="/cms/favicon.ico">

	<script type="text/javascript" src="{{ uncache('cms/libs/libs.js') }}"></script>
	<script type="text/javascript" src="{{ uncache('cms/libs/nestable/jquery.nestable.js') }}"></script>
	<script type="text/javascript" src="{{ uncache('cms/bootstrap/js/moment.js') }}"></script>
	<script type="text/javascript" src="{{ uncache('cms/bootstrap/js/bootstrap.js') }}"></script>
	<script type="text/javascript" src="{{ uncache('cms/bootstrap/js/bootstrap-datetimepicker.js') }}"></script>
	<script type="text/javascript" src="{{ uncache('cms/libs/fancybox/jquery.fancybox.js') }}"></script>
	<script type="text/javascript" src="{{ uncache('cms/ckeditor/ckeditor.js') }}"></script>
	<script type="text/javascript" src="{{ uncache('cms/libs/myLib.js') }}"></script>
	<script type="text/javascript" src="{{ uncache('cms/adaptive.js') }}"></script>
	<script type="text/javascript" src="{{ uncache('cms/fields.js') }}"></script>
	<script type="text/javascript" src="{{ uncache('cms/table.js') }}"></script>
	<script type="text/javascript" src="{{ uncache('cms/drop.js') }}"></script>
	<script type="text/javascript" src="{{ uncache('cms/js.js') }}"></script>
</head>
<body>
	@if (Session::has('message'))
		<div id="shake_message" class="modal fade bs-example-modal-sm in" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="false">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="mySmallModalLabel">{{ Session::get('message')['title'] }}</h4>
					</div>
					
					<div class="modal-body">{{ Session::get('message')['text'] }}</div>
				</div>
			</div>
		</div>
	@endif

	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="navbar-header">
			<a class="navbar-brand" href="/">Shake.CMS</a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li>
					<a href="/">перейти на сайт</a>
				</li>
			</ul>
			
			{{--
			<ul class="nav navbar-nav">
				<li class="active"><a href="/admin">Страницы</a></li>
				<li><a href="/users">Пользователи</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Дополнительно <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="#">Action</a></li>
						<li><a href="#">Another action</a></li>
						<li><a href="#">Something else here</a></li>
						<li class="divider"></li>
						<li class="dropdown-header">Nav header</li>
						<li><a href="#">Separated link</a></li>
						<li><a href="#">One more separated link</a></li>
					</ul>
				</li>
			</ul>
			--}}
			
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="glyphicon glyphicon-user"></i> Админ <span class="caret"></span>
					</a>

					<ul class="dropdown-menu">
						<li>
							<a href="{{ route('usersEditAdmin', array('id' => Auth::id())) }}"><i class="glyphicon glyphicon-cog"></i> Профиль</a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="/logout"><i class="glyphicon glyphicon-off"></i> Выйти</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
		
	</div>

	<?
//	print_r(Route::currentRouteName());
	?>
	
	<div class="sidebar">
		@include('cms::widgets.mainMenu.default')
	</div>
	
	<div class="content">
		<div class="content_inner">
			@yield('content')
		</div>
	</div>
	
	
</body>
</html>
