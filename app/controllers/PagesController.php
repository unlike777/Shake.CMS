<?php

class PagesController extends BaseController {

	public function def() {
		$item = Page::where('is_home', '=', 1)->firstOrFail();
		
		$templ = empty($item->template) ? 'default' : $item->template;
		
		return View::make('pages.templates.'.$templ, array('item' => $item));
	}
	
	public function pages($slug) {
		$item = Page::where('slug', '=', $slug)->where('link', '=', '')->firstOrFail();
		
		SEO::set($item);
		Menu::add($item);

		$parent = $item;

		while ($parent = $parent->parent){
			Menu::add($parent);
		}
		
		$templ = empty($item->template) ? 'default' : $item->template;
		
		return View::make('pages.templates.'.$templ, array('item' => $item));
	}

}
