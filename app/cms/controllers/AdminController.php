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
			$obj->saveUploadFiles($data);

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
		 * @var $obj Eloquent|Page|User
		 */

		if (Request::has('id') ) {
			$id = Request::get('id');

			if (!($obj = $this->model->find($id)))
				return Redirect::route($module.'DefaultAdmin', Session::get('shake.url.'.$module))
					->with('message', array('title' => 'Ошибка', 'text' => 'Объекта с id = '.$id.' не существует'));

			$obj->delete();
			return Redirect::route($module.'DefaultAdmin', Session::get('shake.url.'.$module));
		} else if (Request::has('objects')) {
			foreach (Request::get('objects') as $id) {
				if ($obj = $this->model->find($id)) {
					$obj->delete();
				}
			}

			return Response::json(array('error' => 0));
		}
	}

	public function create() {

		$module = $this->getModuleName();

		/**
		 * @var $obj Eloquent|Page|User
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
			$obj->saveUploadFiles($data);

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

		$input = Input::only(array('file', 'field'));
		$validation = $file->validate($input);
		if ($parent && $validation->passes()) {
			$file->field = Input::get('field');
			$file->saveUploadFiles($input);
			if ($file->save()) {
				$parent->morphMany('StickyFile', 'parent')->save($file);
				return Response::json(array('error' => 0, 'data' => $file->file));
			}
		}

		return Response::json(array('error' => 1, 'data' => 'Сохранить файл не удалось'));
	}

	public function upload_delete() {

		if (Input::has('id')) {
			if ($file = StickyFile::find(Input::get('id'))) {
				$file->delete();
			}
		}

		return Response::json(array('error' => 0));
	}

}
