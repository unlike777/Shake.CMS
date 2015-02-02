<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends ShakeModel implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	protected $fillable = array('active', 'email', 'password', 'group');

	protected $fields = array(
		'active' => array(
			'type' => 'bool',
			'title' => 'Активность',
			'filter' => 1,
		),
		'email' => array(
			'type' => 'text',
			'title' => 'Эл. почта',
			'filter' => 1,
		),
		'password' => array(
			'type' => 'password',
			'title' => 'Пароль',
		),
		'created_at' => array(
			'type' => 'text',
			'title' => 'Дата создания',
		),
		'group' => array(
			'type' => 'select',
			'title' => 'Группа',
			'filter' => 1,
			'values' => array(
				0 => '',
				1 => 'Администраторы',
				2 => 'Пользователи',
			),
		),
	);

	/**
	 * Для создания и редактирования пользователя используются разные правила
	 * @param $data
	 * @param $behavior
	 * @return \Illuminate\Validation\Validator
	 */
	public function validate($data, $behavior = 'default') {
		$rules = array(
			'active' => 'boolean',
			'email' => 'required|min:5|email|unique:users,email',
			'password' => 'min:6',
		);

		if (!empty($this->id)) {
			$rules['email'] = $rules['email'].','.$this->id;
		} else {
			$rules['password'] = 'required|min:6';
		}

		if ($behavior == 'onAuth') {
			$rules = array(
				'email' => 'required|min:5|email',
				'password' => 'required|min:6',
			);
		}


		return Validator::make($data, $rules);
	}

	/**
	 * Сохранение хэша пароля
	 * @param array $attributes
	 * @return $this|void
	 */
	public function fill(array $attributes) {
		
		if (isset($attributes['password'])) {
			$pass = trim($attributes['password']);

			if ($pass == '') {
				unset($attributes['password']);
			} else {
				$attributes['password'] = Hash::make($pass);
			}
		}
		
		parent::fill($attributes);
	}

}
