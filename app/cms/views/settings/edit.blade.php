@extends('cms::layouts.main')

@section('content')

<div class="container-fluid">

	<h1>Настройки → Редактирование Настройки</h1>
	
	<br><br>
	
	<div class="row">
	
		{{ Form::model($item) }}
			
			@include('cms::widgets.form.default', array('item' => $item))
		
			<br>
		
			<div class="col-xs-12">
				<div class="form-group">
					{{ Form::submit('Сохранить', array('class' => 'btn btn-default', 'name' => 'save')) }}
					&nbsp;&nbsp;
					{{ Form::submit('Применить', array('class' => 'btn btn-default', 'name' => 'apply')) }}
					
					&nbsp;&nbsp;&nbsp; или &nbsp;&nbsp;&nbsp;
					
					{{ link_to_route($module.'DefaultAdmin', 'Вернуться назад', Session::get('shake.url.'.$module)) }}
				</div>
			</div>
	
		{{ Form::close() }}
		
		
		@include('cms::widgets.stickyFiles.default', array('item' => $item))
		
	</div>
</div>

@stop