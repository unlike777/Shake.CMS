@extends('admin.layouts.main')

@section('content')

<div class="container-fluid">

	<h1>Пользователи → Редактирование Пользователя</h1>
	
	<br><br>
	
	<div class="row">
	
		{{ Form::model($item) }}
			
			@include('admin.widgets.form.default', array('item' => $item))
		
			<br>
		
			<div class="col-xs-12">
				<div class="form-group">
					{{ Form::submit('Сохранить', array('class' => 'btn btn-default', 'name' => 'save')) }}
					&nbsp;&nbsp;
					{{ Form::submit('Применить', array('class' => 'btn btn-default', 'name' => 'apply')) }}
					
					&nbsp;&nbsp;&nbsp; или &nbsp;&nbsp;&nbsp;
					
					{{ link_to_route('usersDefaultAdmin', 'Вернуться назад', Session::get('shake.url.'.$module)) }}
				</div>
			</div>
	
		{{ Form::close() }}
		
		
		@include('admin.widgets.stickyFiles.default', array('item' => $item))
		
	</div>
</div>

@stop