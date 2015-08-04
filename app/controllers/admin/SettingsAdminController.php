<?php

class SettingsAdminController extends AdminController {

	public function __construct() {
		$this->model = new Setting();
	}

}
