<?php
/**
 * Trait для добавления поведения ошибок к классу
 * 
 * Created by PhpStorm.
 * User: UNLIKE
 * Date: 31.10.2014
 * Time: 22:52
 */ 

trait ErrorsTrait {
	/**
	 * массив ошибок
	 * @var array
	 */
	protected $errors = array();

	/**
	 * Проверяет существует ли ошибки
	 * @return bool
	 */
	public function issetErrors() {
		return count($this->errors) > 0 ? true : false;
	}

	/**
	 * Возвращает массив ошибок
	 * @return array|bool
	 */
	public function getErrors() {
		return $this->issetErrors() ? $this->errors : false;
	}

	/**
	 * Возвращает все ошибки в текстовом виде
	 * @param string $dlm - разделитель
	 * @return string
	 */
	public function getErrorsText($dlm = ' ') {
		if ($this->issetErrors()) {
			return implode($dlm, $this->errors);
		}
		return '';
	}

	/**
	 * Возвращает первую ошибку
	 * @return bool
	 */
	public function firstError() {
		if ($this->issetErrors()) {
			return $this->errors[0];
		}
		
		return false;
	}

	/**
	 * Добавляет ошибку в массив
	 * @param $text - текст ошибки
	 * @return $this
	 */
	public function error($text) {
		$this->errors[] = $text;
		return $this;
	}
}