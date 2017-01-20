<?php

class ShakeModel extends Eloquent {
	
	use ErrorsTrait;

	protected $fillable = array(); 			//поля которые редактируются через форму
	protected $attributes = array(); 		//атрибуты по умолчанию при создании

	protected $fields = array(); 			//поля выводимые в форме в админке

	protected $ajax_files = array();		//поля ajax файлового загрузчика

	/**
	 * Проверяет и сохраняет файлы пришедшие через POST
	 * @param $input
	 */
	public function saveUploadFiles() {
		foreach ($this->getFileFields() as $key) {
			if (Input::hasFile($key)) {
				$file = Input::file($key);

				$ext = $file->getClientOriginalExtension();
				$name = $file->getClientOriginalName();
				$name = str_replace('.'.$ext, '', $name);
				$name = Slug::make($name, '_');

				$type = $file->getMimeType();
				$type = explode('/', $type);

				$type = ($type[0] == 'image') ? 'images' : 'files';

				$destination = '/upload/'.$type.'/'.strtolower(get_class($this)).'/'.date('Y_m').'/';

				$new_name = $name.'.'.$ext;
				
				$i = 0;
				while (file_exists(public_path().$destination.$new_name)) {
					$i++;
					$new_name = $name.'_'.$i.'.'.$ext;
				}

				$file->move(public_path().$destination, $new_name);
				$this->{$key} = $destination.$new_name;
			} else {
				if (Input::has($key.'_del')) {
					$this->{$key} = '';
				}
			}
		}
	}

	/**
	 * Валидация модели,
	 * метод не статичный потому что в зависимости от состояния модели (создание/изменение) правила могут измениться (например в user'ах)
	 *
	 * @param $data - входящие данные
	 * @param $behavior - тип правил которые нужно применить
	 * @return \Illuminate\Validation\Validator
	 */
	public function validate($data, $behavior = 'default') {
		$rules = array();
		return Validator::make($data, $rules);
	}

	/**
	 * Вернет все файловые поля
	 * @return array
	 */
	public function getFileFields() {
		$tmp = array();
		foreach ($this->fields as $key => $item) {
			if (isset($item['type']) && ($item['type'] == 'file')) {
				$tmp[] = $key;
			}
		}
		return $tmp;
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
	public function prepareData($data) {

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
	 * Вернет список ajax'овых файловых заргузчиков
	 * @return array
	 */
	public function getAjaxFields() {
		return $this->ajax_files;
	}
	
	/**
	 * Возвратит все приклепленные файлы к объекту
	 * @param null $field - доп. фильтр по типу поля
	 * @return \Illuminate\Database\Eloquent\Relations\MorphMany
	 */
	public function stickyFiles($field = NULL) {
		$query = $this->morphMany('StickyFile', 'parent');
		
		if ($field) {
			$query->where('field', '=', $field);
		}
		
		return $query;
	}
	
	/**
	 * Возвратит сео текст для данного объекта
	 * @return array|\Illuminate\Database\Eloquent\Relations\MorphMany
	 */
	public function uniqueFields() {
		return $this->MorphMany('Field', 'parent');
	}
    
    /**
     * Выведет значение конкретного уникального поля, если такое есть.
     * @param $alias
     * @return string
     */
	public function unique($alias)
    {
        $field = $this->uniqueFields()->where('field', '=', $alias);
        if ($field)
        {
            return $field->is_file ? $field->file : $field->text;
        }
        
        return '';
    }
	
	/**
	 * Возвратит сео текст для данного объекта
	 * @return array|\Illuminate\Database\Eloquent\Relations\morphOne
	 */
	public function seoText() {
		return $this->morphOne('SeoText', 'parent');
	}
	
	/**
	 * @return bool|null
	 * @throws Exception
	 */
	public function delete() {
		
		$this->seoText()->delete();
		
		foreach ($this->stickyFiles()->get() as $file) {
			$file->delete();
		}
		
		foreach ($this->getFileFields() as $key) {
			Resizer::image($this->{$key})->deleteCache();
			@unlink(public_path().$this->{$key});
		}
		return parent::delete();
	}

	/**
	 * @param array $options
	 * @return bool
	 */
	public function save(array $options = array()) {

		foreach ($this->getFileFields() as $key) {

			$origin = $this->getOriginal($key);
			if (!empty($origin)) {
				if ($this->{$key} != $origin) {
					Resizer::image($origin)->deleteCache();
					@unlink(public_path().$origin);
				}
			}

		}

		/**
		 * Особенно полезно для файловых полей, теперь им в базе не нужно указывать IS_NULL
		 */
		foreach ($this->getFillable() as $name) {
			if (is_null($this->{$name})) {
				$this->{$name} = '';
			}
		}

		return parent::save($options);
	}
	
	/**
	 * Вернет список всех значений справочника у поля
	 * @param $field
	 * @return array
	 */
	public function getList($field) {
		if (isset($this->fields[$field]['values'])) {
			$values = $this->fields[$field]['values'];
			if (is_array($values)) {
				return $values;
			}
		}
		
		return array();
	}
	
	/**
	 * Вернет конкретное значение у поля справочника
	 * @param $field
	 * @return null
	 */
	public function listVal($field) {
		$arr = $this->getList($field);
		
		if (array_key_exists($this->{$field}, $arr)) {
			return $arr[$this->{$field}];
		}
		
		return NULL;
	}
	
	/**
	 * Проверяет есть ли у класса поле active (нужно для талицы в админке)
	 * @return bool
	 */
	public function hasActive() {
		return in_array('active', $this->fillable) ? true : false;
	}
	
	/**
	 * Записывает информацию в лог при удалении объекта
	 * @return $this
	 */
	public function log_on_delete() {
		$log = new Logger('delete.log');
		
		$obj_info = array('model' => class_basename($this));
		foreach (array('id', 'title', 'email', 'file', 'field') as $field) {
			$obj_info[$field] = $this->{$field};
		}
		
		$str = date('[Y-m-d H:i:s]').'   '
			.fit_line('['.Request::getClientIp().']', 19).' '
			.fit_line('['.user_field('email').']', 25)
			.json_encode($obj_info, JSON_UNESCAPED_UNICODE);
		
		$log->add($str)->save();
		
		return $this;
	}
	
}
