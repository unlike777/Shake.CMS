@extends('cms::layouts.main')

@section('content')

<div class="containter-fluid">

	<h1>Структура → Дерево сайта</h1>
	
	<br>
	
	<div class="row">
    	<div class="col-md-7">
    	
    		<a class="btn btn-default" href="{{ route('pagesCreateAdmin') }}">Создать</a>
			<br><br>
			
			@if (count($items) == 0)
				<h3>Ни одной страницы не найдено!</h3>
				<br>
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
    		<h3>Информация</h3>
			<br>
			
			<p>
				<h4>Новые пользователи</h4>
				<b>Сегодня:</b> {{ User::where('created_at', '>', date('Y-m-d 00:00:00'))->count() }} &nbsp; &nbsp;
				<b>За неделю:</b> {{ User::where('created_at', '>', date('Y-m-d 00:00:00', strtotime('-7 day')))->count() }} &nbsp; &nbsp;
				<b>За месяц:</b> {{ User::where('created_at', '>', date('Y-m-d 00:00:00', strtotime('-1 month')))->count() }} &nbsp; &nbsp;
				<br><br>
				Посмотреть <a href="{{ route('usersDefaultAdmin') }}">всех пользователей</a>
			</p>
		</div>
    </div>
	
	

</div>

@stop
