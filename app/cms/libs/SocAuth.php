<?php
/**
 * Реализация авторизации через соц. сети через протокол OAuth 2.0
 * 
 * Created by PhpStorm.
 * User: UNLIKE
 * Date: 02.04.2015
 * Time: 15:50
 */

/*
Schema::dropIfExists('profiles');
Schema::create('profiles', function($table)
{
	$table->integer('id', true);
	$table->integer('user_id')->index();
	$table->string('provider');
	$table->string('soc_id')->index();
	$table->string('email');
	$table->string('name');
	$table->timestamps();
});
*/

class SocAuth {
	
	/**
	 * текущий провайдер vk|fb
	 * @var string
	 */
	private static $cur_provider = '';
	
	/**
	 * Конфиги возможнных соц. сетей
	 * @var array
	 */
	private static $config = array(
		'vk' => array(
			'app_id' 	=> '',
			'secret' 	=> '',
			'scope' 	=> 'status,email',
			'back_url' 	=> '/users/soc/vk',
			'version' 	=> '5.29',
			'enable'	=> true,
			'name'		=> 'Вконтакте',
		),
		'fb' => array(
			'app_id' 	=> '',
			'secret' 	=> '',
			'scope' 	=> 'email,public_profile',
			'back_url' 	=> '/users/soc/fb',
			'enable'	=> true,
			'name'		=> 'Facebook',
		),
	);
	
	/**
	 * Вернет список всех активных соц. сетей
	 * @return array
	 */
	public static function getSocs() {
		$arr = array();
		
		$user_socs = array();
		if (!Auth::guest()) {
			$user_socs = Auth::user()->profiles()->get();
		}
		
		foreach (self::$config as $key => $item) {
			if (self::getVal($item['enable']) == true) {
				
				$item['user_has'] = false;
				foreach ($user_socs as $soc){
					if ($soc->provider == $key) {
						$item['user_has'] = true;
					}
				}
				
				$arr[$key] = $item;
			}
		}
		
		return $arr;
	}
	
	/**
	 * Вернет данные пользователя из соц. сети или false в случае возникновения ошибок
	 * @param $provider
	 * @return bool|mixed|string
	 * array('provider', 'soc_id', 'email', 'name')
	 */
	public static function getUserData($provider) {
		//проверяем существование конфига
		if (!array_key_exists($provider, self::$config)) {
			return false;
		}
		
		self::$cur_provider = $provider;
		
		//если соц. сеть отключена сбрасываем
		if (!self::config('enable')) {
			return false;
		}
		
		//если не задан back_url тоже сбрасываем
		if (self::back_url() == '') {
			return false;
		}
		
		if ($provider == 'vk') {
			return self::connectVk();
		} else if ($provider == 'fb') {
			return self::connectFb();
		}
		
		return false;
	}
	
	/**
	 * Вернет значение конфига с учетом текущего провайдера
	 * @param $key
	 * @return string
	 */
	private static function config($key) {
		if (isset(self::$config[self::$cur_provider][$key])) {
			return self::$config[self::$cur_provider][$key];
		}
		
		return '';
	}
	
	/**
	 * Сгенерирует переменную state и сохранит ее в сессии для дальней проверки
	 * Доп. безопасность
	 * @return int
	 */
	private static function genState() {
		$border = 10000000;
		$rand = rand($border, $border*10 - 1);
		
		Session::set('soc.'.self::$cur_provider.'.state', $rand);
		Session::save();
		
		return $rand;
	}
	
	/**
	 * Проверит переданную в соц. сеть переменную state со значеним в сессии
	 * @param $state
	 * @return bool
	 */
	private static function checkState($state) {
		if (Session::get('soc.'.self::$cur_provider.'.state') == $state) {
			return true;
		}
		
		return false;
	}
	
	/**
	 * Генерирует ссылку для возрата обратно с учетом текущего домена
	 * @return string
	 */
	private static function back_url() {
		$back_url = self::config('back_url');
		
		if (!empty($back_url)) {
			return Request::root().$back_url;
		}
		
		return '';
	}
	
	/**
	 * Проверяет существование перемной и возвращает ее, в обратном случае вернет пустоту
	 * @param $p
	 * @return string
	 */
	private static function getVal(&$p) {
		return isset($p) ? $p : '';
	}
	
	/**
	 * Логика подключения к Вконтакте
	 * @return array|bool
	 */
	private static function connectVk() {
		
		if (!Input::has('code')) {
			$url = "https://oauth.vk.com/authorize?client_id=".self::config('app_id')."&scope=".self::config('scope')."&redirect_uri=".self::back_url()."&response_type=code&v=".self::config('version')."&state=".self::genState();
			Redirect::to($url)->send();
		}
		
		if (!self::checkState(Input::get('state'))) {
			return false;
		}
		
		$code = Input::get('code');
		
		$url = "https://oauth.vk.com/access_token?client_id=".self::config('app_id')."&client_secret=".self::config('secret')."&code=$code&redirect_uri=".self::back_url();
		
		$data = json_decode(file_get_contents($url), true);
		
		if (!self::getVal($data['user_id'])) {
			return false;
		}
		
		$ret = array(
			'soc_id' => self::getVal($data['user_id']),
			'email' => self::getVal($data['email']),
			'name' => '',
			'provider' => self::$cur_provider,
		);
		
		return $ret;
	}
	
	/**
	 * Логика подключения к Facebook'у
	 * @return array|bool
	 */
	private static function connectFb() {
		
		if (!Input::has('code')) {
			$url = "http://www.facebook.com/dialog/oauth?client_id=".self::config('app_id')."&redirect_uri=".self::back_url()."&state=".self::genState()."&scope=".self::config('scope');
			Redirect::to($url)->send();
		}
		
		if (!self::checkState(Input::get('state'))) {
			return false;
		}
		
		$code = Input::get('code');
		
		$url = "https://graph.facebook.com/oauth/access_token?client_id=".self::config('app_id')."&redirect_uri=".self::back_url()."&client_secret=".self::config('secret')."&code=$code";
//		$url = str_replace('&amp;', '&', $url);
		
		$data = @file_get_contents($url);
		@parse_str($data, $data);
		
		if (!isset($data['access_token'])) {
			return false;
		}
		
		$url = "https://graph.facebook.com/me?access_token=". $data['access_token'].'&fields=id,first_name,last_name,email,picture';
		$data = json_decode(file_get_contents($url), true);
		
		if (!self::getVal($data['id'])) {
			return false;
		}
		
		$ret = array(
			'soc_id' => self::getVal($data['id']),
			'email' => self::getVal($data['email']),
			'name' => self::getVal($data['first_name']).' '.self::getVal($data['last_name']),
			'provider' => self::$cur_provider,
		);
		
		return $ret;
	}
	
}