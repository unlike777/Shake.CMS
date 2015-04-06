<?php

class Profile extends ShakeModel {
	
	protected $fillable = array('user_id', 'provider', 'soc_id', 'name', 'email');

//	protected $attributes = array(
//		'page_id' => 0,
//		'active' => 1,
//	);
	
	protected $fields = array(
		'user_id' => array(
			'type' => 'text',
			'title' => 'USER ID',
		),
		'provider' => array(
			'type' => 'text',
			'title' => 'Соц. сеть',
		),
		'soc_id' => array(
			'type' => 'text',
			'title' => 'Соц. идентификатор',
		),
		'name' => array(
			'type' => 'text',
			'title' => 'Имя',
		),
		'email' => array(
			'type' => 'text',
			'title' => 'Эл. почта',
		),
	);
	
	public function user() {
		return $this->belongsTo('User', 'user_id');
	}
	
//	protected $ajax_files = array(
//		'images',
//		'test',
//	);

	public function validate($data, $behavior = 'default') {
		
		$rules = array(
			'user_id' => 'required|integer',
			'provider' => 'required',
			'soc_id' => 'required',
		);

		/*
		if ($behavior == 'onImport') {
			$rules['xml_id'] = 'required|integer|unique:colors,xml_id';
		}

		if (!empty($this->id)) {
			$rules['xml_id'] .= ','.$this->id;
		}
		*/
		
		return Validator::make($data, $rules);
	}
	
}
