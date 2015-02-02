@extends('admin.layouts.main')

@section('content')

<div class="containter-fluid">

	<h1>Структура → Дерево сайта</h1>
	
	<br>
	
	<div class="row">
    	<div class="col-md-7">
    	
    		<a class="btn btn-default" href="{{ route('pagesCreateAdmin') }}">Создать</a>
			<br><br>
			
			@if (count($items) == 0)
				Ни одной страницы не найдено!
			@else
			
			<div class="dd">
			
				<div class="list-group tree">
					<ol class="dd-list">
						@foreach ($items as $item)
							
							{{ $item->oneLine() }}
						
						@endforeach
					</ol>
				</div>
				
			</div>
			
			@endif
			
			<a class="btn btn-default" href="{{ route('pagesCreateAdmin') }}">Создать</a>
    	
    		<div class="clear"></div>
    	</div>
    	
    	<div class="col-md-5">
    		<h3>Дополнительная информация</h3>
            <p>Новых пользователей: 15</p>
            <p>Новых комментариев: 10</p>
            <p>Хитов за сегодня: 150</p>
		</div>
    </div>
	
	

</div>

@stop