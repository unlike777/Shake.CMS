<?php
/**
 * Вспомогательный класс для определения активных пунктов меню
 * 
 * Created by PhpStorm.
 * User: UNLIKE
 * Date: 03.02.2015
 * Time: 20:21
 */ 

class Menu {
	
	private static $active = array();
	
	private static function getClass($obj) {
		if ($obj instanceof Eloquent) {
			$class = get_class($obj);
			$class = strtolower($class);
			return $class;
		}
		
		return '';
	}
	
	public static function add($obj) {
		if ($obj instanceof Eloquent) {
			if (!empty($obj->id)) {
				$class = self::getClass($obj);
				self::$active[$class] = $obj->id;
			}
		}
	}
	
	public static function isActive($obj) {
		if ($obj instanceof Eloquent) {
			if (!empty($obj->id)) {
				$class = self::getClass($obj);
				if (isset(self::$active[$class])) {
					if (in_array($obj->id, self::$active[$class])) {
						return true;
					}
				}
			}
		}
		
		return false;
	}
}