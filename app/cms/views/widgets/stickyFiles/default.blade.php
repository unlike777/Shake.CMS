
@if ($item->exists)
		
	<div class="clear"></div>
		
	@foreach($item->getAjaxFields() as $field => $fname)
		
		<br><br>
		<div class="clear"></div>
		
		<h4>{{ $fname }}</h4>
		
		<div class="drop" data-id="{{ $item->id }}" data-field="{{ $field }}">
			<div class="drop__zone_wr">
				<div class="drop__zone">
					Для загрузки, перетащите файлы сюда
				</div>
			</div>
			
			<div class="drop__file_list">
				@foreach($item->stickyFiles($field)->get() as $file)
					@include('cms::widgets.stickyFiles._item', array('file' => $file, 'field' => $field))
				@endforeach
				{{--<div class="drop__file_item"></div>--}}
			</div>
			
			<div class="clear"></div>
		</div>
		
	@endforeach
	

@endif
