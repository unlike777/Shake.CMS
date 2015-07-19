<?php

class InfoAdminController extends AdminController {

	public function __construct() {
//		$this->model = new User();
	}
	
	public function def() {
		return View::make('admin.info.list');
	}
	
	public function php() {
		phpinfo();
	}
	
}
