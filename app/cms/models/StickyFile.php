<?php

class StickyFile extends ShakeModel {

	protected $table = 'files';
	
	protected $fillable = array('file', 'field');

	protected $attributes = array();
	
	protected $fields = array(
		'file' => array(
			'type' => 'file',
			'title' => 'Файл',
		),
		'field' => array(
			'type' => 'text',
			'title' => 'Поле',
		),
	);
	
	public function validate($data, $behavior = 'default') {
		
		$rules = array(
			'file' => 'required|max:'.(1024*5),
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
