<div class="row">
	<div class="col-md-8">
	
		@foreach($item->getFormFields() as $fname => $field)
				
			@if ($field['type'] == 'text')
				
				<div class="col-xs-6">
					<div class="form-group">
						{{ Form::label($fname, $field['title']) }}
						{{ Form::text($fname, null, array('class' => 'form-control')) }}
					</div>
				</div>
	
			@elseif ($field['type'] == 'not_editable')
	
				<div class="col-xs-6">
					<div class="form-group">
						{{ Form::label($fname, $field['title']) }}
						{{ Form::text($fname, null, array('class' => 'form-control', 'disabled' => 'disabled')) }}
					</div>
				</div>
				
			@elseif ($field['type'] == 'date')
							
				<div class="col-xs-6">
					<div class="form-group">
						{{ Form::label($fname, $field['title']) }}
						<div class='input-group date' id='datetimepicker_{{ $fname }}'>
							{{ Form::text($fname, null, array('class' => 'form-control')) }}
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
					</div>
					
					<script type="text/javascript">
						$(function () {
							$('#datetimepicker_{{ $fname }}').datetimepicker({
								locale: 'ru',
								format: 'YYYY-MM-DD HH:mm:ss'
							});
						});
					</script>
				</div>
				
			@elseif ($field['type'] == 'textarea')
				
				<div class="col-xs-12">
					<div class="form-group">
						{{ Form::label($fname, $field['title']) }}
						{{ Form::textarea($fname, null, array('class' => 'form-control')) }}
					</div>
				</div>
				
			@elseif ($field['type'] == 'ckeditor')
					
				<div class="col-xs-12">
					<div class="form-group">
						{{ Form::label($fname, $field['title']) }}
						{{ Form::textarea($fname, null, array('class' => 'form-control')) }}
					</div>
				</div>
				
				<script type="text/javascript">
					var ckeditor = CKEDITOR.replace('{{$fname}}');
				</script>
				
			@elseif ($field['type'] == 'file')
	
					@if (empty($item->{$fname}) || !file_exists(public_path().$item->{$fname}))
						<div class="col-xs-6">
							<div class="form-group">
								{{ Form::label($fname, $field['title']) }}
								{{ Form::file($fname) }}
							</div>
						</div>
					@else
						<div class="col-xs-6">
							<div class="form-group">
								{{ Form::label($fname, $field['title']) }} <br>
								<a href="{{ $item->{$fname} }}" target="_blank">
	
									<?
									$img_check = false;
									try {
										Image::make(public_path().$item->{$fname});
										$img_check = true;
									} catch (Exception $e) {}
									?>
	
									@if ( $img_check )
										<img src="{{ Resizer::image($item->{$fname})->make(200, 100) }}">
									@else
										Скачать ({{ $item->{$fname} }}) <br>
									@endif
	
								</a>
								{{ Form::checkbox($fname.'_del', 0, 0, array('id' => $fname.'_del')) }}
								{{ Form::label($fname.'_del', 'Удалить?') }}
								{{ Form::hidden($fname, null, array('class' => 'form-control')) }}
							</div>
						</div>
					@endif
				
			@elseif ($field['type'] == 'password')
					
				<div class="col-xs-6">
					<div class="form-group">
						{{ Form::label($fname, $field['title']) }}
						{{ Form::text('', '', array('style' => 'display: none;')) }} {{-- autocomplete disable --}}
						{{ Form::password($fname, array('class' => 'form-control')) }}
					</div>
				</div>
			
			@endif
		
		@endforeach
		
		<div class="clear"></div>
	</div>
  
	<div class="col-md-4">
		@foreach($item->getFormFields() as $fname => $field)
					
			@if ($field['type'] == 'bool')
				
				<div class="col-lg-6">
					<div class="form-group">
						{{ Form::hidden($fname, 0) }}
						{{ Form::checkbox($fname, 1, NULL, array('id' => $fname)) }}
						{{ Form::label($fname, $field['title']) }}
					</div>
				</div>
			
			@elseif ($field['type'] == 'select')
				
				<div class="col-xs-12">
					<div class="form-group">
						<?
						if (!is_array($field['values'])) {
							eval('$tmp = '.$field['values']);
							$field['values'] = $tmp;
						}
						?>
						
						{{ Form::label($fname, $field['title']) }}
						{{ Form::select($fname, $field['values'], null, array('class' => 'form-control')) }}
					</div>
				</div>
			
			@endif
		
		@endforeach
	</div>
</div>


