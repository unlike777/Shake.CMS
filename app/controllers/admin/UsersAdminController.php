<?php

class UsersAdminController extends AdminController {

	public function __construct() {
		$this->model = new User();
	}

}
