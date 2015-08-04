<?php

class PagesAdminController extends AdminController {
	
	public function __construct() {
		$this->model = new Page();
	}
	
	public function def() {
		$items = Page::where('page_id', '=', 0)->orderBy('position')->get();
		
		$open_pages = array();
		if (isset($_COOKIE['admin_pages'])) {
			foreach ($_COOKIE['admin_pages'] as $key => $val) {
				$open_pages[] = $key;
			}
		}
		
		return View::make('cms::'.$this->getModuleName().'.list')
			->with(array('items' => $items, 'open_pages' => $open_pages));
	}

//	public function tree() {
//		/**
//		 * @var $obj Page
//		 */
//
//		if (Request::ajax()) {
//			$obj = Page::find(Input::get('id'));
//			return Response::json(array('data' => $obj->subTree()));
//		}
//
//		return Redirect::route('defaultAdmin')
//			->with('message', array('title' => 'Ошибка', 'text' => 'Страница не найдена'));
//	}

	public function position() {
		/**
		 * @var $obj Page
		 */

		if (Request::ajax()) {
			
			if (!Input::has('id') || !Input::has('parent_id') || !Input::has('before_id')) {
				return Response::json(array('error' => 1, 'text' => 'Не все параметры переданы'));
			}
			
			if ($obj = $this->model->find(Input::get('id'))) {
				$obj->setParent(Input::get('parent_id'), Input::get('before_id'));
			}
			
			return Response::json(array('error' => 0));
		}

		return Redirect::route($this->getModuleName().'DefaultAdmin')
			->with('message', array('title' => 'Ошибка', 'text' => 'Страница не найдена'));
	}

}
