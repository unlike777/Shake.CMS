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
			
			<div class="col-xs-6">
				<div class="form-group">
					{{ Form::label($fname, $field['title']) }}
					{{ Form::file($fname) }}
				</div>
			</div>
			
		@elseif ($field['type'] == 'password')
				
			<div class="col-xs-6">
				<div class="form-group">
					{{ Form::label($fname, $field['title']) }}
					{{ Form::password($fname, array('class' => 'form-control')) }}
				</div>
			</div>
			
		@elseif ($field['type'] == 'select')
        				
			<div class="col-xs-6">
				<div class="form-group">
					{{ Form::label($fname, $field['title']) }}
					{{ Form::select($fname, $field['values'], null, array('class' => 'form-control')) }}
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
					{{ Form::checkbox($fname, 1, NULL, array('id' => $fname)) }}
					{{ Form::label($fname, $field['title']) }}
				</div>
			</div>
			@endif
		
		@endforeach
	</div>
</div>


