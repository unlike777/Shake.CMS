<?php

class Page extends ShakeModel {
	
	protected $fillable = array('active', 'title', 'content', 'file', 'slug', 'template');

	protected $attributes = array(
		'page_id' => 0,
		'active' => 1,
	);

	protected $rules = array(
		'slug' => 'required|alpha_dash|between:2,255|unique:pages,slug',
		'title' => 'required|min:2',
		'content' => 'required|min:5',
		'active' => 'boolean',
		'template' => 'required',
	);

	protected $file_rules = array(
		'file' => 'max:1048576',
	);
	
	protected $fields = array(
		'title' => array(
			'type' => 'text',
			'title' => 'Заголовок страницы',
		),
		'slug' => array(
			'type' => 'text',
			'title' => 'Псевдо адрес',
		),
		'active' => array(
			'type' => 'bool',
			'title' => 'Активность',
		),
		'content' => array(
			'type' => 'ckeditor',
			'title' => 'Содержание',
		),
		'file' => array(
			'type' => 'file',
			'title' => 'Файл',
		),
		'template' => array(
			'type' => 'select',
			'title' => 'Шаблон страницы',
			'values' => array(
				'default' => 'Стандартный',
				'second'  => 'Второстепенный',
			),
		),
	);
	
	protected $ajax_files = array(
		'images',
		'test',
	);

	/**
	 * Для создания и редактирования страниц используются разные правила
	 * @param $data
	 * @return \Illuminate\Validation\Validator
	 */
	public function validate($data) {
		$arr = $this->getAllRules();

		if (!empty($this->id)) {
			$arr['slug'] = $arr['slug'].','.$this->id;
		}
		
		return Validator::make($data, $arr);
	}
	
	
	public function hasChilds() {
		$count = Page::hasMany('Page')->take(1)->get()->count();
		return $count > 0 ? true : false;
	}
	
	public function isOpen() {
		if ( isset($_COOKIE['admin_pages']) && $this->hasChilds() ) {
			if (array_key_exists($this->id, $_COOKIE['admin_pages'])) {
				return true;
			}
		}
		return false;
	}

	/**
	 * выводит html дочерний ветки для текущей страницы в дереве
	 * @return string
	 */
	public function subTree() {
		if ( $this->hasChilds() ) {
			$items = Page::where('page_id', '=', $this->id)->where('id', '!=', $this->id)->orderBy('position')->get();
			return View::make('admin.pages._tree')->with('items', $items)->render();
		}
		return '';
	}

	/**
	 * выводит html текущего элемента для дерева
	 * @return string
	 */
	public function oneLine() {
		if ( $this->exists() ) {
			return View::make('admin.pages._one_line')->with('item', $this)->render();
		}
		return '';
	}

	/**
	 * Устанавливает родителя для страницы
	 * @param int $parent_id - id родительской страницы, если 0, то верхний уровень
	 * @param bool $before_id - id элемента за которым вставить текущую страницу, если false - вставляет в конец, если 0 в начало
	 * @return $this
	 */
	public function setParent($parent_id = 0, $before_id = false) {
		
		if ($parent_id != 0 && !($parent = Page::find($parent_id)) ) {
			$this->error('Страницы выбранной в качестве родителя не существует');
			return $this;
		}

		$this->page_id = $parent_id;

		if ($before_id !== false) {
			if ($before_id == 0) {
				//вставляем в начало
				$new_pos = 0;
				Page::where('id', '!=', $this->id)->where('page_id', '=', $parent_id)->increment('position');
			} else {
				//вставляем после конкретного элемента
				if ($before_obj = Page::find($before_id)) {
					$new_pos = $before_obj->position;
					Page::where('id', '!=', $this->id)->where('page_id', '=', $parent_id)->where('position', '>', $new_pos)->increment('position');
					$new_pos++;
				} else {
					$this->error('Страницы выбранной в качестве предыдущего элемента не существует');
					return $this;
				}
			}
		} else {
			//вставляем в самый конец
			//$new_pos = Page::where('id', '!=', $this->id)->orderBy('page_id', 'desc')->limit(1)->get('position');
			$new_pos = Page::where('id', '!=', $this->id)->where('page_id', '=', $parent_id)->max('position');
			$new_pos++;
		}

		$this->position = $new_pos;
		$this->save();
		
		return $this;
	}
	
	
	
	public function url() {
		return '/pages/'.$this->slug;
	} 
}
