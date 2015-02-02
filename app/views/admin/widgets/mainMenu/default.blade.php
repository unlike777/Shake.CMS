
<ul class="nav nav-list">
	@foreach ($menu as $item)
		@if ($item['route'] == $route)
			<li class="active"><a href="{{$item['url']}}"><i class="glyphicon {{$item['glyph']}}"></i> {{$item['name']}}</a></li>
		@else
			<li><a href="{{$item['url']}}"><i class="glyphicon {{$item['glyph']}}"></i> {{$item['name']}}</a></li>
		@endif
	@endforeach
</ul>
