@extends('layouts.main')

@section('content')


<div class="main">
	<div class="wrap">
	
		<br><br>
		
		{{ Form::model($user, array('class' => "form-signin", 'role' => 'form')) }}
			<h2 class="form-signin-heading">Личные данные</h2>
			
			<div class="form-group" style="margin-bottom: 10px;">
				{{ Form::text('email', null, array('class' => 'form-control', 'placeholder' => 'Ваша Эл. почта')) }}
			</div>

			<div class="form-group" style="margin-bottom: 10px;">
				{{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Пароль')) }}
			</div>
		
			<div class="form-group" style="margin-bottom: 10px;">
				{{ Form::password('password2', array('class' => 'form-control', 'placeholder' => 'Подтверждение пароля')) }}
			</div>
		
			@if (Session::has('message'))
				<div class="form-group">
					<p class="help-block">{{ Session::get('message') }}</p>
				</div>
			@endif
			
			<button type="submit" class="btn btn-default">Сохранить</button>	
		{{ Form::close() }}

		<br><br>
		
	</div>
</div>


@stop
