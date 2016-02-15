<?php

class UsersAdminController extends AdminController {

	protected $decls = array('section' => 'пользователи', 'many' => 'пользователей', 'one' => 'пользователя');
	
	public function __construct() {
		$this->model = new User();
		parent::__construct();
	}
	
	public function def() {
		
		$this->table->add('email', 'Эл. почта', 0);
		$this->table->add('created_at', 'Дата регистрации', 0, function($val, $obj) {
			return Date::parse($val)->format('j mm Y H:i:s'); 
		});
		$this->table->add('updated_at', 'Дата обновления', 0, function($val, $obj) {
			return Date::parse($val)->format('j mm Y H:i:s');
		});
		
		return parent::def();
	}

}
