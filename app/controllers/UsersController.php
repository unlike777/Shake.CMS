<?php

class UsersController extends BaseController {

	public function login() {

		/**
		 * @var $validation \Illuminate\Validation\Validator
		 */
		
		if (Input::has('signin')) {
			$data = Input::only(array('email', 'password'));
			$validation = User::getModel()->validate($data, 'onAuth');

			if ($validation->fails()) {
				return Redirect::refresh()
					->with( array('message' => $validation->errors()->first()) )
					->withInput(Input::all());
			}

			if (Auth::attempt($data)) {
				if (Input::has('back_url')) {
					return Redirect::to(Input::get('back_url', '/'));
				} else {
					return Redirect::intended('/');
				}
			} else {
				return Redirect::refresh()
					->with( array('message' => 'Неправильная пара логин/пароль') )
					->withInput(Input::all());
			}
		}
		
		return View::make('users.login');
	}

	public function logout() {
		
		Auth::logout();
		return Redirect::back();
	}

}
