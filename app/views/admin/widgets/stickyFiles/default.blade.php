
@if (!empty($item->id))
		
	<div class="clear"></div>
		
	@foreach($item->getAjaxFields() as $field)
		
		<br><br>
		<div class="clear"></div>
		
		<div class="drop" data-id="{{ $item->id }}" data-field="{{ $field }}">
			<div class="drop__zone_wr">
				<div class="drop__zone">
					Для загрузки, перетащите файлы сюда
				</div>
			</div>
			
			<div class="drop__file_list">
				@foreach($item->stickyFiles($field) as $file)
					<div class="drop__file_item" data-id="{{ $file->id }}">
						<div class="drop__file_item_del glyphicon glyphicon-remove"></div>
						<div class="drop__file_item_in">
							<a href="{{ $file->file }}" target="_blank">{{ $file->file }}</a>
						</div>
					</div>
				@endforeach
				{{--<div class="drop__file_item"></div>--}}
			</div>
			
			<div class="clear"></div>
		</div>
		
	@endforeach
	

@endif
