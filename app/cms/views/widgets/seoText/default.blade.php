<div class="row">
	<div class="col-md-12 seo_block">
		
		<div class="col-xs-4">
			<div class="form-group">
				<h4>SEO оптимизация</h4>
			</div>
		</div>
		
		<div class="clear"></div>
		
		<div class="col-xs-4">
			<div class="form-group">
				{{ Form::label('seo_title', 'Заголовок окна страницы') }}
				{{ Form::text('seo_title', $item->seoText ? $item->seoText->title : '', array('class' => 'form-control')) }}
			</div>
		</div>
		
		<div class="col-xs-4">
			<div class="form-group">
				{{ Form::label('seo_keywords', 'Ключевые слова') }}
				{{ Form::text('seo_keywords', $item->seoText ? $item->seoText->keywords : '', array('class' => 'form-control')) }}
			</div>
		</div>
		
		<div class="col-xs-4">
			<div class="form-group">
				{{ Form::label('seo_description', 'Мета описание') }}
				{{ Form::text('seo_description', $item->seoText ? $item->seoText->description : '', array('class' => 'form-control')) }}
			</div>
		</div>
	
		{{ Form::hidden('seo_block_enable', 1) }}
		
		<div class="clear"></div>
	</div>
</div>
