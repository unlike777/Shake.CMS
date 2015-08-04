<?php

class StickyFile extends ShakeModel {

	protected $table = 'files';
	
	protected $fillable = array('file', 'field');

	protected $attributes = array();

	protected $rules = array(
//		'title' => 'required|min:2',
//		'content' => 'required|min:5',
//		'active' => 'boolean',
		'field' => 'required|max:255',
	);

	protected $file_rules = array(
		'file' => 'max:1048576',
	);
	
	protected $fields = array(
		'file' => array(
			'type' => 'file',
			'title' => 'Файл',
		),
	);


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
