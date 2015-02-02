@extends('layouts.login')

@section('content')

<form class="form-signin" role="form" action="" method="post">
	<h2 class="form-signin-heading">Please sign in</h2>
	
	<div class="form-group">
		{{ Form::text('email', null, array('class' => 'form-control', 'placeholder' => 'Enter email')) }}
		{{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password')) }}
	</div>
	
	<div class="checkbox">
		<label>
			<input type="checkbox"> Remember me
		</label>
	</div>
	
	@if (Session::has('message'))
		<div class="form-group">
			<p class="help-block">{{ Session::get('message') }}</p>
		</div>
	@endif
	
	<button type="submit" class="btn btn-default" name="signin" value="1">Sign in</button>
</form>


@stop
