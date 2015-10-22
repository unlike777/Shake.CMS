@extends('cms::layouts.main')

@section('content')

<div class="container-fluid">
	
	<h1>Структура → Редактирование Страницы</h1>
	
	<br><br>
	
	<div class="row">
	
		{{ Form::model($item, array('files' => true)) }}
		
			@include('cms::widgets.seoText.default', array('item' => $item))
		
			@include('cms::widgets.form.default', array('item' => $item))
		
			<br>
		
			<div class="col-xs-12">
				<div class="form-group">
					{{ Form::submit('Сохранить', array('class' => 'btn btn-default', 'name' => 'save')) }}
					&nbsp;&nbsp;
					{{ Form::submit('Применить', array('class' => 'btn btn-default', 'name' => 'apply')) }}
					
					&nbsp;&nbsp;&nbsp; или &nbsp;&nbsp;&nbsp; 
					
					{{ link_to_route('pagesDefaultAdmin', 'Вернуться назад') }}
				</div>
			</div>
	
		{{ Form::close() }}
		
		@include('cms::widgets.fields.default', array('item' => $item))
		
		@include('cms::widgets.stickyFiles.default', array('item' => $item))
		
	</div>
</div>


@stop