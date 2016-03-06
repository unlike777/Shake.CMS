<?php

/*
Schema::dropIfExists('settings');
Schema::create('settings', function(\Illuminate\Database\Schema\Blueprint $table)
{
	$table->integer('id', true);
	$table->string('title');
	$table->text('text');
	$table->timestamps();
});
*/

class Setting extends ShakeModel {
	
	protected $fillable = array('title', 'alias', 'text');

//	protected $attributes = array(
//		'page_id' => 0,
//		'active' => 1,
//	);
	
	protected $fields = array(
		'title' => array(
			'type' => 'text',
			'title' => 'Назначение',
		),
		'alias' => array(
			'type' => 'text',
			'title' => 'Алиас (для быстрого вызова)',
		),
		'text' => array(
			'type' => 'textarea',
			'title' => 'Текст',
		),
	);
	
//	protected $ajax_files = array(
//		'images' => 'Картинки',
//		'test' => 'Тест',
//	);

	public function validate($data, $behavior = 'default') {
		
		$rules = array(
			'title' => 'required|min:2',
			'alias' => 'required|alpha_dash|between:2,255|unique:settings,alias',
			'text' => '',
		);
		
		if (!empty($this->id)) {
			$rules['alias'] = $rules['alias'].','.$this->id;
		}
		
		return Validator::make($data, $rules);
	}

	/**
	 * Вернет значение или пустоту по алиасу
	 * @param $alias
	 * @return mixed
	 */
	public static function getValue($alias) {
		return static::firstOrNew(array('alias' => $alias))->text;
	}
	
}
