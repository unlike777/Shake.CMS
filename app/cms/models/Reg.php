<?php

/*
Schema::dropIfExists('regs');
Schema::create('regs', function(\Illuminate\Database\Schema\Blueprint $table)
{
	$table->integer('id', true);
	$table->string('key')->index();
	$table->string('value');
	$table->timestamps();
});
*/

class Reg extends ShakeModel {
	
	protected $fillable = array('key', 'value');

//	protected $attributes = array(
//		'page_id' => 0,
//		'active' => 1,
//	);
	
	protected $fields = array(
		'key' => array(
			'type' => 'text',
			'title' => 'Ключ',
		),
		'value' => array(
			'type' => 'text',
			'title' => 'Значение',
		),
	);
	
//	protected $ajax_files = array(
//		'images' => 'Картинки',
//		'test' => 'Тест',
//	);

	public function validate($data, $behavior = 'default') {
		
		$rules = array(
			'key' => 'required|min:2|unique:regs,key',
			'value' => '',
		);
		
		if (!empty($this->id)) {
			$rules['key'] = $rules['key'].','.$this->id;
		}
		
		return Validator::make($data, $rules);
	}
	
	
	/**
	 * Устанавливает значение по ключу, возвращает переданное значение
	 * @param $alias
	 * @param $value
	 * @return mixed
	 */
	public static function set($key, $value) {
		$obj = self::where('key', '=', $key)->first();
		if (!$obj) {
			$obj = new self();
		}
		
		$data = $obj->prepareData(array('key' => $key, 'value' => $value));
		$validation = $obj->validate($data);
		
		if ($validation->passes()) {
			$obj->fill($data);
			$obj->save();
		}
		
		return $value;
	}
	
	/**
	 * Вернет значение по ключю
	 * @param array $key
	 * @param null $defValue
	 * @return mixed|null
	 */
	public static function get($key, $defValue = NULL) {
		$obj = self::where('key', '=', $key)->first();
		if ($obj) {
			return $obj->value;
		}
		
		return $defValue;
	}
	
	/**
	 * Удалит значение с заданным ключом
	 * @param $key
	 */
	public static function del($key) {
		self::where('key', '=', $key)->delete();
	}
	
}
