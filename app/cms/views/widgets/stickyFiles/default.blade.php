
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
					<div class="drop__file_item {{ $file->is_image() ? 'drop__file_item--image' : '' }}" data-id="{{ $file->id }}">
						<div class="drop__file_item_del glyphicon glyphicon-remove"></div>
						
						@if ($file->is_image())
							<a href="{{ $file->file }}" target="_blank" class="fancybox" rel="sticky[{{ $field }}]">
								<img src="{{ Resizer::image($file->file)->make(160, 160) }}">
							</a>
						@else
							<a href="{{ $file->file }}" target="_blank">
								<div class="drop__file_item_in">
									{{ $file->file }}
								</div>
							</a>
						@endif
						
					</div>
				@endforeach
				{{--<div class="drop__file_item"></div>--}}
			</div>
			
			<div class="clear"></div>
		</div>
		
	@endforeach
	

@endif
