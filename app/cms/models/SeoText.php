<?php

/*
Schema::dropIfExists('seo_texts');
Schema::create('seo_texts', function(\Illuminate\Database\Schema\Blueprint $table)
{
	$table->integer('id', true);
	$table->string('title');
	$table->string('keywords');
	$table->string('description');
	$table->integer('parent_id')->index();
	$table->string('parent_type');
	$table->timestamps();
});
*/


class SeoText extends ShakeModel {
	
	protected $fillable = array('title', 'keywords', 'description');

//	protected $attributes = array(
//		'page_id' => 0,
//		'active' => 1,
//	);
	
	protected $fields = array(
		'title' => array(
			'type' => 'text',
			'title' => 'Заголовок',
		),
		'keywords' => array(
			'type' => 'text',
			'title' => 'Ключевые слова',
		),
		'description' => array(
			'type' => 'text',
			'title' => 'Мета описание',
		),
	);
	
//	protected $ajax_files = array(
//		'images',
//		'test',
//	);

	public function validate($data, $behavior = 'default') {
		
		$rules = array(
			'title' => '',
		);
		
		return Validator::make($data, $rules);
	}
	
	
	/**
	 * Вернет родителя к которому прикреплен файл
	 * @return \Illuminate\Database\Eloquent\Relations\MorphTo
	 */
	public function parent() {
		return $this->morphTo();
	}
	
}
