<?php

class StickyFile extends ShakeModel {

	protected $table = 'files';
	
	protected $fillable = array('file', 'field', 'parent_id', 'parent_type');

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
		'field' => array(
			'type' => 'text',
			'title' => 'Поле',
		),
	);
	
	public function validate($data, $behavior = 'default') {
		
		$rules = array(
//			'parent_type' => 'required',
//			'parent_id' => 'required|integer',
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

	/**
	 * Проверяет является ли файл изображением
	 * @return bool
	 */
	public function is_image() {
		
		$file_path = public_path($this->file);
		
		if (file_exists($file_path)) {
			$t = new Symfony\Component\HttpFoundation\File\File($file_path);
			$type = $t->getMimeType();
			$type = explode('/', $type);
			
			if ($type[0] == 'image') {
				return true;
			}
		}
		
		return false;
	}
}
