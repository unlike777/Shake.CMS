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
		
		@if (count($info))
			<a href="{{ route('pagesEditAdmin', array($item->id)) }}"> {{ $item->title }}</a><span>, {{ implode(', ', $info) }}</span>
		@else
			<a href="{{ route('pagesEditAdmin', array($item->id)) }}"> {{ $item->title }} </a>
		@endif
		
		
		
		
		<div class="dd-right">
			{{ link_to_route('pagesCreateAdmin', '', array('parent_id' => $item->id), array('class' => 'glyphicon glyphicon-plus', 'title' => 'Добавить в этот раздел'))  }}
			{{ link_to_route('pagesEditAdmin', '', array('id' => $item->id), array('class' => 'glyphicon glyphicon-pencil', 'title' => 'Редактировать'))  }}
			{{ link_to($item->url(), '', array('class' => 'glyphicon glyphicon-share', 'target' => '_blank', 'title' => 'Посмотреть на сайте')) }}
			{{ link_to_route('pagesDeleteAdmin', '', array('id' => $item->id), array('class' => 'glyphicon glyphicon-trash table__row_delete', 'title' => 'Удалить'))  }}
		</div>
	</div>

	@if ($item->hasChilds())
		{{ $item->subTree() }}
	@endif
	
</li>
