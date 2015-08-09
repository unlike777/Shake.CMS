<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>{{ SEO::title() }}</title>
	
	<meta name="keywords" content="{{ SEO::keywords() }}">
	<meta name="description" content="{{ SEO::description() }}">
	
</head>
<body>
	@yield('content')
</body>
</html>
