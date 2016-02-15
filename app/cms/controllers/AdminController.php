<?php

class AdminController extends BaseController {

	/**
	 * Основная модель используемая в модуле
	 * @var $model Eloquent|Page
	 */
	protected $model;
	
	/**
	 * Вернет название модуля - название модели + "s", в нижем регистре
	 * используется для редиректов и вьюх
	 * @return string
	 */
	public function getModuleName() {
		return empty($this->model->module_name) ? strtolower(get_class($this->model)).'s' : $this->model->module_name;
	}

	public function def() {

		$module = $this->getModuleName();

		$query = Input::query();

		if (!empty($query)) {
			Session::set('shake.url.'.$module, $query);
		}

		return View::make('cms::'.$module.'.list')
			->with(array(
				'model' => $this->model,
				'module' => $module,
			));
	}

	public function edit($id) {

		$module = $this->getModuleName();

		/**
		 * @var $obj ShakeModel|Page|User
		 */

		$obj = $this->model->find($id);

		if (!$obj)
			return Redirect::route($module.'DefaultAdmin', Session::get('shake.url.'.$module))
				->with('message', array('title' => 'Ошибка', 'text' => 'Объекта с id = '.$id.' не существует'));

		if (!empty($_POST)) {

			$data = $obj->prepareData(Input::all());
			$validation = $obj->validate($data);

			if ($validation->fails()) {
				return Redirect::refresh()
					->with('message', array('title' => 'Ошибка', 'text' => $validation->errors()->first() ))
					->withInput(Input::except($obj->getFileFields()));
			}
			
			$obj->fill($data);
			$obj->saveUploadFiles();

			if ($obj->save()) {
				
				if (Input::has('seo_block_enable')) {
					
					$seo = $obj->seoText()->first();
					if (!$seo) {
						$seo = new SeoText();
					}
					
					$seo->title = Input::get('seo_title');
					$seo->keywords = Input::get('seo_keywords');
					$seo->description = Input::get('seo_description');
					
					$obj->seoText()->save($seo);
					
				}
				
				if (Input::has('save')) {
					return Redirect::route($module.'DefaultAdmin', Session::get('shake.url.'.$module));
				} else {
					return Redirect::refresh();
				}
			} else {
				return Redirect::refresh()
					->with('message', array('title' => 'Ошибка', 'text' => 'Объекта сохранить не удалось'))
					->withInput(Input::except($obj->getFileFields()));
			}
		}

		return View::make('cms::'.$module.'.edit')
			->with( array(
				'item' => $obj,
				'module' => $module,
			));
	}


	public function active() {
		/**
		 * @var $obj Page
		 */
		if (Request::ajax()) {
			if (Input::has('objects')) {
				foreach (Input::get('objects') as $id) {
					if ($obj = $this->model->find($id)) {
						$obj->active = ($obj->active == 1) ? 0 : 1;
						$obj->save();
					}
				}
			}
			return Response::json(array('error' => 0));
		}

		return Redirect::route($this->getModuleName().'DefaultAdmin')
			->with('message', array('title' => 'Ошибка', 'text' => 'Страница не найдена'));
	}



	public function delete() {

		$module = $this->getModuleName();

		/**
		 * @var $obj Eloquent|Page|User|ShakeModel
		 */

		if (Request::has('id') ) {
			$id = Request::get('id');

			if (!($obj = $this->model->find($id)))
				return Redirect::route($module.'DefaultAdmin', Session::get('shake.url.'.$module))
					->with('message', array('title' => 'Ошибка', 'text' => 'Объекта с id = '.$id.' не существует'));
			
			$obj->log_on_delete();
			$obj->delete();
			return Redirect::route($module.'DefaultAdmin', Session::get('shake.url.'.$module));
		} else if (Request::has('objects')) {
			foreach (Request::get('objects') as $id) {
				if ($obj = $this->model->find($id)) {
					$obj->log_on_delete();
					$obj->delete();
				}
			}

			return Response::json(array('error' => 0));
		}
	}

	public function create() {

		$module = $this->getModuleName();

		/**
		 * @var $obj Eloquent|Page|User|ShakeModel
		 */

		$obj = new $this->model;

		if (!empty($_POST)) {

			$data = $obj->prepareData(Input::all());
			$validation = $obj->validate($data);

			if ($validation->fails()) {
				return Redirect::refresh()
					->with('message', array('title' => 'Ошибка', 'text' => $validation->errors()->first() ))
					->withInput(Input::except($obj->getFileFields()));
			}

			$obj->fill($data);
			$obj->saveUploadFiles();

			if ($obj->save()) {
				
				if (Input::has('seo_block_enable')) {
					
					$seo = $obj->seoText()->first();
					if (!$seo) {
						$seo = new SeoText();
					}
					
					$seo->title = Input::get('seo_title');
					$seo->keywords = Input::get('seo_keywords');
					$seo->description = Input::get('seo_description');
					
					$obj->seoText()->save($seo);
					
				}
				
				if (Input::has('save')) {
					return Redirect::route($module.'DefaultAdmin', Session::get('shake.url.'.$module));
				} else {
					return Redirect::route($module.'EditAdmin', array($obj->id));
				}
			} else {
				return Redirect::refresh()
					->with('message', array('title' => 'Ошибка', 'text' => 'Объекта сохранить не удалось'))
					->withInput(Input::except($obj->getFileFields()));
			}
		}

		return View::make('cms::'.$module.'.edit')
			->with( array(
				'item' => $obj,
				'module' => $module,
			));
	}




	public function upload($id) {
		$file = new StickyFile();

		$parent = $this->model->find($id);
		$field = Input::get('field');

		$input = Input::only(array('file', 'field'));
		$validation = $file->validate($input);
		if ($parent && $validation->passes()) {
			$file->field = $field;
			$file->saveUploadFiles();
			if ($file->save()) {
				$parent->morphMany('StickyFile', 'parent')->save($file);
				$data = View::make('cms::widgets.stickyFiles._item', compact('file', 'field'))->render();
				return Response::json(array('error' => 0, 'data' => $data));
			}
		}

		return Response::json(array('error' => 1, 'data' => 'Сохранить файл не удалось'));
	}

	public function upload_delete() {

		/**
		 * @var $file StickyFile
		 */
		if (Input::has('id')) {
			if ($file = StickyFile::find(Input::get('id'))) {
				$file->log_on_delete();
				$file->delete();
			}
		}

		return Response::json(array('error' => 0));
	}
	
	
	
	public function	field_create($parent_id) {
		$field = new Field();
		
		/**
		 * @var $parent ShakeModel
		 */
		$parent = $this->model->find($parent_id);
		
		if (!$parent) {
			return Response::json(array('error' => 1, 'data' => 'Родитель не найден'));
		}
		
		$data = $field->prepareData(Input::all());
		$validation = $field->validate($data);
		
		if ($validation->fails()) {
			return Response::json(array('error' => 1, 'data' => $validation->errors()->first()));
		}
		
		$field->fill($data);
		
		if ($field->save()) {
			$parent->uniqueFields()->save($field);
			return Response::json(array('error' => 0, 'data' => View::make('cms::widgets.fields.default', array('item' => $parent))->render()));
		}
		
		return Response::json(array('error' => 1, 'data' => 'Сохранить файл не удалось'));
	}
	
	public function	field_update($id) {
		/**
		 * @var $field Field
		 */
		$field = Field::find($id);
		
		if (!$field) {
			return Response::json(array('error' => 1, 'data' => 'Поле не найдено!'));
		}
		
		$data = $field->prepareData(Input::all());
		$validation = $field->validate($data);
		
		if ($validation->fails()) {
			return Response::json(array('error' => 1, 'data' => $validation->errors()->first()));
		}
		
		$field->fill($data);
		
		if ($field->save()) {
			return Response::json(array('error' => 0, 'data' => View::make('cms::widgets.fields.default', array('item' => $field->parent))->render()));
		}
		
		return Response::json(array('error' => 1, 'data' => 'Сохранить файл не удалось'));
	}
	
	public function	field_delete($id) {
		/**
		 * @var $field Field
		 */
		$field = Field::find($id);
		
		if (!$field) {
			return Response::json(array('error' => 1, 'data' => 'Поле не найдено!'));
		}
		
		$field->log_on_delete();
		$field->delete();
		
		return Response::json(array('error' => 0, 'data' => View::make('cms::widgets.fields.default', array('item' => $field->parent))->render()));
	}
	
}
