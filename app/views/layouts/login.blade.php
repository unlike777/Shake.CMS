<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Laravel PHP Framework</title>

	<link type="text/css" rel="stylesheet" href="{{ uncache('css_js_admin/bootstrap/css/bootstrap.css') }}">
	<link type="text/css" rel="stylesheet" href="{{ uncache('css_js_admin/bootstrap/css/bootstrap-theme.css') }}">
	<link type="text/css" rel="stylesheet" href="{{ uncache('css_js_admin/libs/nestable/style.css') }}">
	
	<link type="text/css" rel="stylesheet" href="{{ uncache('css_js_admin/style.css') }}">

	<script type="text/javascript" src="{{ uncache('css_js_admin/libs/libs.js') }}"></script>
	<script type="text/javascript" src="{{ uncache('css_js_admin/libs/nestable/jquery.nestable.js') }}"></script>
	<script type="text/javascript" src="{{ uncache('css_js_admin/bootstrap/js/bootstrap.js') }}"></script>
	<script type="text/javascript" src="{{ uncache('css_js_admin/libs/myLib.js') }}"></script>
	<script type="text/javascript" src="{{ uncache('css_js_admin/js.js') }}"></script>
</head>
<body style="background-color: #f5f5f5; padding: 40px;">
	@yield('content')
</body>
</html>
