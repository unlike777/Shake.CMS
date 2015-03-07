<?php
/**
 * Вспомогательный класс для отладки запросов
 * 
 * Created by PhpStorm.
 * User: UNLIKE
 * Date: 03.02.2015
 * Time: 20:21
 */ 

class SqlDebug {
	
	private static $sort = true;
	private static $strings = array();
	private static $time = 0;
	
	public static function add($query, $time) {
		self::$strings[] = array('query' => $query, 'time' => $time);
		self::$time += $time;
	}
	
	public static function out() {
		
		if (!empty(self::$time)) {
			pr('SQL time: '.self::$time);
			pr('SQL count: '.count(self::$strings));
		}
		
		if (self::$sort) {
			usort(self::$strings, function($a, $b) {
				if ($a['time'] == $b['time']) {
					return 0;
				}
				return ($a['time'] > $b['time']) ? -1 : 1;
			});
		}
		
		foreach (self::$strings as $item) {
			pr($item['query'].' /* '.$item['time'].' */');
		}
	}
}