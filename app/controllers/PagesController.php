<?php

class PagesController extends BaseController {

	public function def() {
		return View::make('pages.pages');
	}
	
	public function pages($slug) {
		$item = Page::where('slug', '=', $slug)->firstOrFail();
		
		SEO::set($item);
		Menu::add($item);
		
		$templ = empty($item->template) ? 'default' : $item->template;
		
		return View::make('pages.templates.'.$templ, array('item' => $item));
	}

}
