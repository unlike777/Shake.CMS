<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Здравствуйте!</h2>
		
		<p>
			Вы зарегистрировались на сайте <a href="{{ url('/') }}">{{ url('/') }}</a>
		</p>
		
		@if (isset($pass))
			<p>
				Ваш логин: <b>{{ $user->email }}</b> <br>
				Ваш пароль: <b>{{ $pass }}</b> <br>
			</p>
		@endif
		
		<p>С уважением, администрация {{ url('/') }}</p>
	</body>
</html>
