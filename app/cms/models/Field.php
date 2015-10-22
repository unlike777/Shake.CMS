<?php

/*
Schema::dropIfExists('fields');
Schema::create('fields', function(\Illuminate\Database\Schema\Blueprint $table)
{
	$table->integer('id', true);
	$table->text('text');
	$table->string('file')->nullable();
	$table->string('field');
	$table->integer('parent_id')->index();
	$table->string('parent_type');
	$table->boolean('is_file');
	$table->timestamps();
});
*/

class Field extends ShakeModel {
	
	protected $fillable = array('text', 'file', 'field', 'parent_id', 'parent_type', 'is_file');

	protected $attributes = array();
	
	protected $fields = array(
		'parent_type' => array(
			'type' => 'not_editable',
			'title' => 'PARENT TYPE',
		),
		'parent_id' => array(
			'type' => 'not_editable',
			'title' => 'PARENT ID',
		),
		'file' => array(
			'type' => 'file',
			'title' => 'Файл',
		),
		'text' => array(
			'type' => 'textarea',
			'title' => 'Текст',
		),
		'field' => array(
			'type' => 'text',
			'title' => 'Поле',
		),
		'is_file' => array(
			'type' => 'bool',
			'title' => 'Поле файловое?',
		),
	);
	
	public function validate($data, $behavior = 'default') {
		
		$rules = array(
//			'parent_type' => 'required',
//			'parent_id' => 'required|integer',
			'text' => '',
			'is_file' => 'boolean',
			'file' => 'max:'.(1024*5),
			'field' => 'required|max:255',
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
	
	public function getFileName() {
		if (!empty($this->file)) {
			$tmp = explode('/', $this->file);
			return end($tmp);
		}
		
		return '';
	}
}
