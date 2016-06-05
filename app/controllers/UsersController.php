<?php

class UsersController extends BaseController
{
	
	public function edit() {
		
		/**
		 * @var $user User
		 */
		$user = Auth::user();
		
		if (!empty($_POST)) {
			
			/**
			 * @var $validation \Illuminate\Validation\Validator
			 */
			$data = $user->prepareData(Input::only('email', 'password', 'password2'));
			$validation = $user->validate($data, 'onEdit');
			
			if ($validation->fails()) {
				return Redirect::refresh()
					->with( array('message' => $validation->errors()->first()) )
					->withInput(Input::except($user->getFileFields()));
			}
			
			$user->fill($data);
			$user->saveUploadFiles($data);
			
			if ($user->save()) {
				return Redirect::refresh();
			} else {
				return Redirect::refresh()
					->with( array('message' => 'Объекта сохранить не удалось') )
					->withInput(Input::except($user->getFileFields()));
			}
			
		}
		
		return View::make('users.edit', array('user' => $user));
	}

}
