@if (count($items) == 0)

@else
	<ol class="dd-list">
		@foreach ($items as $item)
		
			{{ $item->oneLine() }}
		
		@endforeach
	</ol>
@endif