<?php

class UsersController extends BaseController {

	public function login() {

		/**
		 * @var $validation \Illuminate\Validation\Validator
		 */
		
		session_start();
		
		if (!empty($_POST)) {
			$data = Input::only(array('email', 'password'));
			$validation = User::getModel()->validate($data, 'onAuth');

			if ($validation->fails()) {
				return Redirect::refresh()
					->with( array('message' => $validation->errors()->first()) )
					->withInput(Input::all());
			}

			if (Auth::attempt($data, Input::has('remember_me'))) {
				
				$user = Auth::getUser();
				if ($user->group == 1) {
					$_SESSION['is_admin'] = 1;
				}
				
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
		
		session_start();
		
		Auth::logout();
		if (isset($_SESSION['is_admin'])) {
			unset($_SESSION['is_admin']);
		}
		return Redirect::back();
	}
	
	public function register() {
		
		if (Input::has('signup')) {
			
			$obj = new User();
			
			$data = Input::only(array('email', 'password', 'password2'));
			$data = $obj->prepareData($data);
			$validation = $obj->validate($data, 'onAdd');
			
			if ($validation->fails()) {

//				if (Request::ajax()) {
//					return Response::json(array('error' => 1, 'data' => $validation->errors()->first()));
//				}
				
				return Redirect::route(Route::current()->getName(), Input::only('back_url'))
					->with( array('message' => $validation->errors()->first()) )
					->withInput(Input::all());
			}
			
			
			$obj->fill($data);
			$obj->saveUploadFiles($data);
			
			if ($obj->save()) {
				Auth::login($obj);

//				if (Request::ajax()) {
//					return Response::json(array('error' => 0));
//				}
				
				if (Input::has('back_url')) {
					return Redirect::to(Input::get('back_url', '/'));
				} else {
					return Redirect::intended('/');
				}
			} else {
//				if (Request::ajax()) {
//					return Response::json(array('error' => 2, 'data' => 'Неправильная пара логин/пароль'));
//				}
				
				return Redirect::route(Route::current()->getName(), Input::only('back_url'))
					->with( array('message' => 'Сохранить пользователя не удалось, повторите попытку') )
					->withInput(Input::all());
			}
		}
		
		return View::make('users.register');
	}
	
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
	
	public function disconnect($provider) {
		$profile = Auth::user()->profiles()->where('provider', '=', $provider)->firstOrFail();
		$profile->delete();
		
		return Redirect::back();
	}
	
	public function soc($provider) {
		
		if (Input::has('back_url')) {
			Session::set('back_url', Input::get('back_url'));
		}
		
		if ($data = SocAuth::getUserData($provider)) {
			if (Auth::guest()) {
				
				$profile = Profile::where('soc_id', '=', $data['soc_id'])
					->where('provider', '=', $data['provider']);
				
				if (!($profile = $profile->first())) {
					return Redirect::route('register', array('back_url' => Request::path()))
						->withInput(array(
							'email' => $data['email'],
						));
				}
				
				if ($user = $profile->user()->first()) {
					Auth::login($user);
					return Redirect::to(Session::pull('back_url', '/'));
				}
				
			} else {
				$user = Auth::user();
				$profile = Profile::where('user_id', '=', $user->id)
					->where('soc_id', '=', $data['soc_id'])
					->where('provider', '=', $data['provider']);
				
				if (!($profile = $profile->first())) {
					$profile = new Profile();
					
					$data = $profile->prepareData(array_merge($data, array('user_id' => $user->id)));
					$validate = $profile->validate($data);
					
					if ($validate->fails()) {
						pr('Ошибка создание соц. профиля');
						pr($validate->errors()->first());
						die;
//						Redirect::route('users.edit')
//							->with( array('message' => 'Сохранить соц. профиль не удалось, попробуйте снова') );
					}
					
					$profile->fill($data);
					if (!$profile->save()) {
						pr('Ошибка создание соц. профиля'); die;
//						Redirect::route('users.edit')
//							->with( array('message' => 'Сохранить соц. профиль не удалось, попробуйте снова') );
					}
				}
				
				return Redirect::to(Session::pull('back_url', '/'));
				
			}
		}
		
		return Redirect::to('/');
	}

}
