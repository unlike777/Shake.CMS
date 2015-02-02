<?php

class ShakeModel extends Eloquent {
	
	use ErrorsTrait;
	
	protected $fillable = array(); 			//поля которые редактируются через форму
	protected $attributes = array(); 		//атрибуты по умолчанию при создании
	
	protected $rules = array(); 			//правила валидации для полей
	protected $file_rules = array(); 		//правила валидации для файловых полей
	
	protected $fields = array(); 			//поля выводимые в форме в админке

	protected $ajax_files = array();		//поля ajax файлового загрузчика

	/**
	 * Проверяет и сохраняет файлы пришедшие через POST
	 * @param $input
	 */
	public function saveUploadFiles($input) {
		foreach ($input as $key => $value) {
			if (array_key_exists($key, $this->file_rules)) {
				if (Input::hasFile($key)) {
					$file = Input::file('file');

					$ext = $file->getClientOriginalExtension();
					$name = $file->getClientOriginalName();
					$name = str_replace('.'.$ext, '', $name);
					
					$type = $file->getMimeType();
					$type = explode('/', $type);
					
					$type = ($type[0] == 'image') ? 'images' : 'files';

					$destination = '/upload/'.$type.'/';
					
					$new_name = $name.'.'.$ext;
					$i = 0;
					while (file_exists(public_path().$destination.$new_name)) {
						$i++;
						$new_name = $name.'_'.$i.'.'.$ext;
					}
					
					$file->move(public_path().$destination, $new_name);
					$this->{$key} = $destination.$new_name;
				}
			}
		}
	}

	/**
	 * Валидация модели,
	 * метод не статичный потому что в зависимости от состояния модели (создание/изменение) правила могут измениться (например в user'ах)
	 * 
	 * @param $data
	 * @return \Illuminate\Validation\Validator
	 */
	public function validate($data) {
		$rules = $this->getAllRules();
		return Validator::make($data, $rules);
	}

	/**
	 * Получаем список всех правил валидации (стандартные + файловые)
	 * @return array
	 */
	public function getAllRules() {
		return array_merge($this->rules, $this->file_rules);
	}

	/**
	 * Вернет все поля формирующие форму редактирования
	 * @return array
	 */
	public function getFormFields() {
		$tmp = array();
		foreach ($this->fields as $key => $item) {
			if (in_array($key, $this->fillable)) {
				$tmp[$key] = $item;
			}
		}
		return $tmp;
	}

	/**
	 * Вернет все поля по которым можно фильтровать в общем списке
	 * @return array
	 */
	public function getFilterFields() {
		$tmp = array();
		foreach ($this->fields as $key => $item) {
			if ( isset($item['filter']) && ($item['filter'] == 1) ) {
				$item['value'] = NULL;
				$tmp['filter['.$key.']'] = $item;
			}
		}
		return $tmp;
	}

	/**
	 * Преобразует входящие данные для модели
	 * Пример. использование псевдо адресов ЧПУ (slug)
	 * @param $data
	 * @return mixed
	 */
	public function transformData($data) {
		
		if (isset($data['slug'])) {
			$slug = $data['slug'];
			if ($data['slug'] == '') {
				if (isset($data['title'])) {
					$slug = $data['title'];
				}
			}
			
			$data['slug'] = Slug::make($slug);
		}
		
		return $data;
	}
	
	/**
	 * Проверяет и присваивает данные в модель пришедшии из формы
	 * Возвращает объект валидации
	 * @return \Illuminate\Validation\Validator
	 */
	public function loadFromPost() {
		$fields = $this->getFillable();
		$data = Input::only($fields);
		
		$data = $this->transformData($data);

		$validation = $this->validate($data);

		if ($validation->passes()) {
			$this->fill($data);
			$this->saveUploadFiles($data);
		}
		
		return $validation;
	}
	
	/**
	 * Вернет список ajax'овых файловых заргузчиков
	 * @return array
	 */
	public function getAjaxFields() {
		return $this->ajax_files;
	}

	/**
	 * Возвратит все приклепленные файлы к объекту
	 * @param $field - доп. фильтр по типу поля
	 * @return array
	 */
	public function stickyFiles($field) {
		if (in_array($field, $this->getAjaxFields())) {
			return $this->morphMany('StickyFile', 'parent')->where('field', '=', $field)->get();
		}
		return array();
	}
	
	public function delete() {
		
		foreach ($this->file_rules as $key => $val) {
			
			Resizer::image($this->{$key})->deleteCache();
			@unlink(public_path().$this->{$key});
			
		}
		
		return parent::delete();
	}
	
}
