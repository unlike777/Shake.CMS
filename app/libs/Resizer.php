<?php

/**
 * Class Resizer
 * Ресайзит картинки и кеширует полученные результаты
 * 
 * Пример
 * Resizer::image('/upload/image.jpg')->make(100, 100);
 * Resizer::image('/upload/image.jpg')->deleteCache();
 * 
 */

class Resizer {
	
	protected static $img = '';
	
	public function __construct($img = '') {
		if (is_file($this->public_path().$img)) {
			self::$img = $img;
		}
	}

	/**
	 * Устанавливаем изображение
	 * @param $img
	 * @return Resizer
	 */
	public static function image($img) {
		return new self($img);
	}

	/**
	 * Возвращает полный путь до картинки
	 * @return string
	 */
	public function full_path() {
		if (!empty(self::$img)) {
			return $this->public_path().self::$img;
		}
		
		return '';
	}

	/**
	 * Возвращает путь до корневой директории
	 * @return string
	 */
	protected function public_path() {
		return public_path();
	}

	/**
	 * Возвращает путь до директории с кешем
	 * @return string
	 */
	protected function cache_path() {
		return '/cache/img';
	}

	/**
	 * Возвращает префикс генерируемый из пути файла
	 * @return mixed|string
	 */
	protected function resize_prefix() {
		$pref = dirname(self::$img);
		$bad_symbols = array("/", " ");
		$pref = str_replace ($bad_symbols, "_", $pref);
		$pref = substr($pref, 1);
		$pref = empty($pref) ? '' : $pref.'_';

		return $pref;
	}

	/**
	 * Удаляет кеш текущей картинки
	 * рекурсивная функция
	 * @param string $del_file
	 * @param string $from_path
	 */
	public function deleteCache($del_file = '', $from_path = '') {
		if (is_dir(public_path().$from_path) && !empty(self::$img)) {
			
			if (empty($del_file)) {
				$del_file = $this->resize_prefix().basename(self::$img);
			}
			
			if (empty($from_path)) {
				$from_path = $this->cache_path().'/';
			}
			
			chdir($this->public_path().$from_path);
			$handle = opendir('.');

			while (($file = readdir($handle)) !== false) {
				if ($file != "." && $file != "..") {

					if (is_dir($this->public_path().$from_path.$file)) {
						$this->deleteCache($del_file, $from_path.$file.'/');
						chdir(public_path().$from_path);
					}

					if (is_file(public_path().$from_path.$file) && $file == $del_file)
						@unlink(public_path().$from_path.$file);
				}
			}
			closedir($handle);
		}
	}

	/**
	 * Ресайзить картинку и кеширует ее
	 * @param int $width
	 * @param int $height
	 * @param int $scale_type
	 * @param int $bg
	 * @return string
	 */
	public function make($width = 0, $height = 0, $scale_type = 0, $bg = 0) {

		if (empty(self::$img)) {
			return '';
		}

		//на случай, если передана не картинка
		try {
			$img = Image::make($this->full_path());
		} catch (Exception $e) {
			return self::$img;
		}
		

		$width = intval($width);
		$height = intval($height);
		$scale_type = ($scale_type != 0) ? 1 : 0; //может быть только 0 или 1

		$pref = $this->resize_prefix();

		//именно такой порядок нужен для быстрого удаления кеша конкретной картинки
		$dir = $this->cache_path().'/'.$width.'x'.$height.'_'.$scale_type.'_'.str_replace('#', '', $bg);
		$resize_file_name = $dir.'/'.$pref.substr(strrchr(self::$img, "/"), 1);

		if (!file_exists($this->public_path() . $resize_file_name)) {
			if (!is_dir($this->public_path() . $dir)) @mkdir($this->public_path() . $dir, 0777, true);

			if (!empty($bg)) {
				$img->fill($bg);
			}

			if ($height > 0 && $width > 0) {

				if (($img->width() <= $width) && ($img->height() <= $height)) {
					return self::$img;
				}

				if ($scale_type == 1) {
					($img->width() < $img->height()) ? $img->heighten($height) : $img->widen($width);
				} else {
					$img->fit($width, $height);
				}

			} else if ($height > 0) {

				if ($img->width() <= $width) {
					return self::$img;
				}

				$img->heighten($height);

			} else if ($width > 0) {

				if ($img->height() <= $height) {
					return self::$img;
				}

				$img->widen($width);

			}

			$img->save(public_path() . $resize_file_name);
		}

		return $resize_file_name;
	}
	
	
}