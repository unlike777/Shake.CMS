<?php

class Setting extends ShakeModel {
	
	protected $fillable = array('title', 'text');

//	protected $attributes = array(
//		'page_id' => 0,
//		'active' => 1,
//	);
	
	protected $fields = array(
		'title' => array(
			'type' => 'text',
			'title' => 'Назначение',
		),
		'text' => array(
			'type' => 'textarea',
			'title' => 'Текст',
		),
	);
	
//	protected $ajax_files = array(
//		'images',
//		'test',
//	);

	public function validate($data, $behavior = 'default') {
		
		$rules = array(
			'title' => 'required|min:2',
			'text' => '',
		);
		
		return Validator::make($data, $rules);
	}
	
}