@if ($item->exists)
	<div class="row" id="ufields">
		<div class="col-md-12 ufields" data-id="{{ $item->id }}">
			
			<div class="col-xs-4">
				<div class="form-group">
					<h4>Уникальные поля</h4>
				</div>
			</div>
			
			<div class="clear"></div>
			
			<div class="ufields__wr">
				{{ Form::open() }}
					<div class="col-xs-4 ufields__item ufields__item--gag">
						<div class="ufields__item_inner">
							<div class="ufields__input">
								{{ Form::text('field', null, array('placeholder' => 'Алиас')) }}
							</div>
							
							<div class="ufields__textarea">
								{{ Form::textarea('text') }}
							</div>
							
							<div class="ufields__btns">
								<div class="btn btn-success btn-xs ufields__save">
									<span class="glyphicon glyphicon-ok"></span> Сохранить
								</div>
								
								<div class="btn btn-danger btn-xs ufields__delete">
									<span class="glyphicon glyphicon-remove"></span> Удалить
								</div>
							</div>
						</div>
					</div>
				{{ Form::close() }}
				
				@if ($item->uniqueFields()->count())
					@foreach($item->uniqueFields()->get() as $field)
						{{ Form::model($field) }}
							<div class="col-xs-4 ufields__item" data-id="{{ $field->id }}">
								<div class="ufields__item_inner">
									<div class="ufields__input">
										{{ Form::text('field', null, array('placeholder' => 'Алиас')) }}
									</div>
									
									<div class="ufields__textarea">
										{{ Form::textarea('text') }}
									</div>
									
									<div class="ufields__btns">
										<div class="btn btn-success btn-xs ufields__save">
											<span class="glyphicon glyphicon-ok"></span> Сохранить
										</div>
										
										<div class="btn btn-danger btn-xs ufields__delete">
											<span class="glyphicon glyphicon-remove"></span> Удалить
										</div>
										
										@if (isset($field_id) && ($field->id == $field_id) )
											<div class="glyphicon glyphicon-ok-sign ufields__sign"></div>
										@endif
									</div>
								</div>
							</div>
						{{ Form::close() }}
					@endforeach
				@endif
				
				<div class="clear"></div>
			</div>
			
			<div class="clear"></div>
			
			<div class="col-xs-4">
				<div class="btn btn-success" id="ufields__add">
					<span class="glyphicon glyphicon-plus"></span> Добавить
				</div>
			</div>
			
			<div class="clear"></div>
		</div>
	</div>
@endif
