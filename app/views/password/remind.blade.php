@extends('layouts.main')

@section('content')

<h1 class="h1">Восстановление пароля</h1>

@if (Session::has('error'))
	<p style="color: red;">{{ Session::get('error') }}</p><br>
@elseif (Session::has('status'))
	<p style="color: green;">{{ Session::get('status') }}</p><br>
@endif

{{Form::open(array('class' => 'form-signin', 'role' => 'form'))}}

	<div class="form form--center">
		<div class="form__line">
			<label>
				<div class="form__line_title">Почта (логин)</div>
				{{ Form::text('email', null, array('class' => 'form-control')) }}
			</label>
		</div>

		<div class="form__line form__line--submit">
			<button type="submit" class="btn" name="signup" value="1">Восстановить</button>
		</div>

		<div class="form__line">
			<a href="{{ route('register') }}">Зарегистрироваться</a>
		</div>
	</div>
	
{{ Form::close() }}

@stop