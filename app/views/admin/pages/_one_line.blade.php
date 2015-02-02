<li class="dd-item dd3-item" data-id="{{ $item->id }}">
	<div class="dd-handle dd3-handle"></div>
	<div class="dd3-content">

		<!--
		@if ($item->hasChilds())

			@if ($item->isOpen())
				<i class="glyphicon glyphicon-minus open_btn"></i>
			@else
				<i class="glyphicon glyphicon-plus open_btn"></i>
			@endif

		@else
			<i class="glyphicon glyphicon-plus glyphicon--opacity open_btn"></i>
		@endif
		-->

		@if ($item->active == 1)
			<i class="glyphicon glyphicon-eye-open eye_btn"></i>
		@else
			<i class="glyphicon glyphicon-eye-close eye_btn"></i>
		@endif
		
		<a href="{{ route('pagesEditAdmin', array($item->id)) }}"> {{ $item->title }} </a>
		
		<div class="dd-right">
			{{ link_to_route('pagesEditAdmin', '', array('id' => $item->id), array('class' => 'glyphicon glyphicon-pencil'))  }}
			{{ link_to($item->url(), '', array('class' => 'glyphicon glyphicon-share', 'target' => '_blank')) }}
			{{ link_to_route('pagesDeleteAdmin', '', array('id' => $item->id), array('class' => 'glyphicon glyphicon-trash table__row_delete'))  }}
		</div>
	</div>

	@if ($item->hasChilds())
		{{ $item->subTree() }}
	@endif
	
</li>