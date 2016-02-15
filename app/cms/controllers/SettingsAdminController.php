<?php

class SettingsAdminController extends AdminController {

	protected $decls = array('section' => 'настройки', 'many' => 'настроек', 'one' => 'настройки');
	
	public function __construct() {
		$this->model = new Setting();
		parent::__construct();
	}
	
	public function def() {
		
		$this->table->add('title', 'Описание', 0);
		$this->table->add('created_at', 'Дата создания', 0, function($val, $obj) {
			return Date::parse($val)->format('j mm Y H:i:s'); 
		});
		$this->table->add('updated_at', 'Дата обновления', 0, function($val, $obj) {
			return Date::parse($val)->format('j mm Y H:i:s');
		});
		
		return parent::def();
	}

}
