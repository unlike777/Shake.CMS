<?php
/**
 * Вспомогательный класс для отладки запросов к БД
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
	
	/**
	 * Добавляет запрос в стек
	 * @param $query
	 * @param $time
	 */
	public static function add($query, $time) {
		self::$strings[] = array('query' => $query, 'time' => $time);
		self::$time += $time;
	}
	
	/**
	 * Выводит полученную информацию о sql запросах
	 */
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
	
	/**
	 * Включает логирование sql зарпосов
	 */
	public static function on() {
		DB::listen(function($query, $bindings, $time)
		{
			
			foreach ($bindings as $i => $binding)
			{
				if ($binding instanceof \DateTime)
				{
					$bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
				}
				else if (is_string($binding))
				{
					$bindings[$i] = "'$binding'";
				}
			}
		
			$query = str_replace(array('%', '?'), array('%%', '%s'), $query);
			$query = vsprintf($query, $bindings);
		
			SqlDebug::add($query, $time/1000);
		});
	}
}