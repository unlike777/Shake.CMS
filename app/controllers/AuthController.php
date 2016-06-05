<?php

class AuthController extends BaseController
{
    
    public function login()
    {
        
        /**
         * @var $validation \Illuminate\Validation\Validator
         */
        
        session_start();
        
        if (!empty($_POST))
        {
            $data = Input::only(array('email', 'password'));
            $data['password'] = trim($data['password']);
            $validation = User::getModel()->validate($data, 'onAuth');
            
            if ($validation->fails())
            {
                return Redirect::refresh()
                    ->with(array('message' => $validation->errors()->first()))
                    ->withInput(Input::all());
            }
            
            if (Auth::attempt($data, Input::has('remember_me')))
            {
                $user = Auth::getUser();
                if ($user->group == 1)
                {
                    $_SESSION['is_admin'] = 1;
                }
                
                if (Input::has('back_url'))
                {
                    return Redirect::to(Input::get('back_url', '/'));
                }
                else
                {
                    return Redirect::intended('/');
                }
            }
            else
            {
                return Redirect::refresh()
                    ->with(array('message' => 'Неправильная пара логин/пароль'))
                    ->withInput(Input::all());
            }
        }
        
        return View::make('users.login');
    }
    
    public function logout()
    {
        
        session_start();
        
        Auth::logout();
        if (isset($_SESSION['is_admin']))
        {
            unset($_SESSION['is_admin']);
        }
        
        return Redirect::back();
    }
    
    public function register()
    {
        
        if (!empty($_POST))
        {
    
            $user = new User();
            
            $data = Input::only(array('email', 'password', 'password2'));
            $data = $user->prepareData($data);
            $validation = $user->validate($data, 'onAdd');
            
            if ($validation->fails())
            {
                
                //				if (Request::ajax()) {
                //					return Response::json(array('error' => 1, 'data' => $validation->errors()->first()));
                //				}
                
                return Redirect::route(Route::current()->getName(), Input::only('back_url'))
                    ->with(array('message' => $validation->errors()->first()))
                    ->withInput(Input::all());
            }
    
    
            $user->fill($data);
            $user->saveUploadFiles($data);
            
            if ($user->save())
            {
                Auth::login($user);
    
                //отправляем письмо об успешной регистрации
                Mail::send('emails.users.register', array('user' => $user), function($message) use ($user) {
                    $message->to($user->email)
                        ->from(Config::get('app.email'))
                        ->subject('Регистрация на сайте');
                });
                
                //				if (Request::ajax()) {
                //					return Response::json(array('error' => 0));
                //				}
                
                if (Input::has('back_url'))
                {
                    return Redirect::to(Input::get('back_url', '/'));
                }
                else
                {
                    return Redirect::intended('/');
                }
            }
            else
            {
                //				if (Request::ajax()) {
                //					return Response::json(array('error' => 2, 'data' => 'Неправильная пара логин/пароль'));
                //				}
                
                return Redirect::route(Route::current()->getName(), Input::only('back_url'))
                    ->with(array('message' => 'Сохранить пользователя не удалось, повторите попытку'))
                    ->withInput(Input::all());
            }
        }
        
        return View::make('users.register');
    }
    
    public function disconnect($provider)
    {
        $profile = Auth::user()->profiles()->where('provider', '=', $provider)->firstOrFail();
        $profile->delete();
        
        return Redirect::back();
    }
    
    public function soc($provider)
    {
        session_start();
        
        if (Input::has('back_url'))
        {
            Session::set('back_url', Input::get('back_url'));
        }
        
        if ($data = SocAuth::getUserData($provider))
        {
            if (Auth::guest())
            {
                //если пользователь не авторизован создаем его
                $profile = Profile::where('soc_id', '=', $data['soc_id'])->where('provider', '=', $data['provider'])->first();
                
                if (!$profile)
                {
                    //создаем пользователя
                    $user = new User();
                    
                    $pass = User::genPass(); //т.к. авториазция через соц. сеть, генерим пароль
                    
                    $tmp_arr = array(
                        'email' => $data['email'],
                        'password' => $pass,
                    );
                    
                    $tmp_arr = $user->prepareData($tmp_arr);
                    $validate = $user->validate($tmp_arr);
                    
                    if ($validate->fails())
                    {
                        //дозапрашиваем данные, если не пришли из соц. сети
                        return Redirect::route('register', array('soc' => 'soc', 'back_url' => Request::path()))
                            ->with(array('message' => $validate->errors()->first()))
                            ->withInput(array(
                                'email' => $data['email'],
                            ));
                    }
                    
                    $user->fill($tmp_arr);
                    $user->save();
                    
                    //отправляем письмо об успешной регистрации
                    Mail::send('emails.users.register', array('user' => $user, 'pass' => $pass), function($message) use ($user) {
                        $message->to($user->email)
                            ->from(Config::get('app.email'))
                            ->subject('Регистрация на сайте');
                    });
                    
                    //прикрепляем профиль соц. сети к пользователю
                    $profile = new Profile();
                    
                    $data = $profile->prepareData(array_merge($data, array('user_id' => $user->id)));
                    $validate = $profile->validate($data);
                    
                    if ($validate->fails())
                    {
                        pr('Ошибка создание соц. профиля');
                        pr($validate->errors()->first());
                        die;
                    }
                    
                    $profile->fill($data);
                    if (!$profile->save())
                    {
                        pr('Ошибка создание соц. профиля');
                        die;
                    }
                }
                
                //авторизуем если все ок
                if ($user = $profile->user()->first())
                {
                    Auth::login($user);
                    
                    if ($user->group == 1) {
                        $_SESSION['is_admin'] = 1;
                    }
                    
                    return Redirect::to(Session::pull('back_url', '/'));
                }
            }
            else
            {
                //коннектим профиль к уже авторизованному пользователю
                $user = Auth::user();
                $profile = Profile::where('user_id', '=', $user->id)
                    ->where('soc_id', '=', $data['soc_id'])
                    ->where('provider', '=', $data['provider']);
                
                if (!($profile = $profile->first()))
                {
                    $profile = new Profile();
                    
                    $data = $profile->prepareData(array_merge($data, array('user_id' => $user->id)));
                    $validate = $profile->validate($data);
                    
                    if ($validate->fails())
                    {
                        pr('Ошибка создание соц. профиля');
                        pr($validate->errors()->first());
                        die;
                        //						Redirect::route('users.edit')
                        //							->with( array('message' => 'Сохранить соц. профиль не удалось, попробуйте снова') );
                    }
                    
                    $profile->fill($data);
                    if (!$profile->save())
                    {
                        pr('Ошибка создание соц. профиля');
                        die;
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
