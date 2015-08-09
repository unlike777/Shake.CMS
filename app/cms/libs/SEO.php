<?php
/**
 * Вспомогательный класс для SEO оптимизации
 * 
 * Created by PhpStorm.
 * User: UNLIKE
 * Date: 03.02.2015
 * Time: 20:21
 */ 

class SEO {
	
	/**
	 * @var ShakeModel
	 */
	private static $obj;
	private static $kinds = array('title', 'keywords', 'description');
	private static $changed = array();
	
	/**
	 * Вернет СЕО текст текущего объекта
	 * @param $kind
	 * @return string
	 */
	private static function getSeoText($kind) {
		$text = '';
		if (self::checkKind($kind)) {
			if (self::$obj) {
				if ($seo = self::$obj->seoText) {
					$text = $seo->{$kind};
				}
				
				if (isset(self::$changed[class_basename(self::$obj)][$kind])) {
					$foo = self::$changed[class_basename(self::$obj)][$kind];
					$text = $foo(self::$obj);
				}
			}
			if (empty($text)) {
				$text = self::getDefSeoText($kind);
			}
		}
		return $text;
	}
	
	/**
	 * Вернет СЕО текст по умолчанию, на случай если никакой текст не найден
	 * @param $kind
	 * @return string
	 */
	private static function getDefSeoText($kind) {
		$text = '';
		if (self::checkKind($kind)) {
			if ($home = Page::where('is_home', '=', 1)->first()) {
				if ($seo = $home->seoText) {
					$text = $seo->{$kind};
				}
			}
		}
		return $text;
	}
	
	/**
	 * Проверяет тип СЕО текста
	 * @param $kind
	 * @return bool
	 */
	private static function checkKind($kind) {
		return in_array($kind, self::$kinds);
	}
	
	/**
	 * Возвращает Заголовок окна
	 * @return string
	 */
	public static function title() {
		return self::getSeoText('title');
	}
	
	/**
	 * Возвращает Ключевые слова
	 * @return string
	 */
	public static function keywords() {
		return self::getSeoText('keywords');
	}
	
	/**
	 * Возвращает Мета описание
	 * @return string
	 */
	public static function description() {
		return self::getSeoText('description');
	}
	
	/**
	 * Установить объект который будет участвовать в генерации СЕО текстов
	 * @param $obj
	 */
	public static function set($obj) {
		if ($obj instanceof ShakeModel) {
			self::$obj = $obj;
		}
	}
	
	/**
	 * Добавляет поведение для разных классов
	 * @param $model
	 * @param $kind
	 * @param $foo
	 */
	public static function change($model, $kind, $foo) {
		if (self::checkKind($kind)) {
			if (class_exists($model)) {
				if (is_callable($foo)) {
					self::$changed[$model][$kind] = $foo;
				}
			}
		}
	}
	
}