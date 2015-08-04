
<ul class="nav nav-list list-group">
	@foreach ($menu as $num => $group)
		@if ($num > 0)
			<li class="nav-divider"></li>
		@endif
		@if (!empty($group['group']))
			<li class="nav-header">{{ $group['group'] }}</li>
		@endif
		@foreach($group['items'] as $item)
			@if ($item['route'] == $route)
				<li class="active"><a href="{{$item['url']}}"><i class="glyphicon {{$item['glyph']}}"></i> {{$item['name']}}</a></li>
			@else
				<li><a href="{{$item['url']}}"><i class="glyphicon {{$item['glyph']}}"></i> {{$item['name']}}</a></li>
			@endif
		@endforeach
	@endforeach
</ul>
