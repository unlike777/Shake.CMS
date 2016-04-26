<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Shake.CMS — Login</title>

	<link type="text/css" rel="stylesheet" href="{{ uncache('cms/bootstrap/css/bootstrap.css') }}">
	<link type="text/css" rel="stylesheet" href="{{ uncache('cms/bootstrap/css/bootstrap-theme.css') }}">
	<link type="text/css" rel="stylesheet" href="{{ uncache('cms/libs/nestable/style.css') }}">
	
	<link type="text/css" rel="stylesheet" href="{{ uncache('cms/style.css') }}">

	<script type="text/javascript" src="{{ uncache('cms/libs/libs.js') }}"></script>
	<script type="text/javascript" src="{{ uncache('cms/libs/nestable/jquery.nestable.js') }}"></script>
	<script type="text/javascript" src="{{ uncache('cms/bootstrap/js/bootstrap.js') }}"></script>
	<script type="text/javascript" src="{{ uncache('cms/libs/myLib.js') }}"></script>
	<script type="text/javascript" src="{{ uncache('cms/js.js') }}"></script>
</head>
<body style="background-color: #f5f5f5; padding: 40px;">
	@yield('content')
</body>
</html>
