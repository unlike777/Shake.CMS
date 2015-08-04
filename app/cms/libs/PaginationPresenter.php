<?php

class PaginationPresenter extends Illuminate\Pagination\Presenter {

	/**
	 * Get HTML wrapper for a page link.
	 *
	 * @param  string  $url
	 * @param  int  $page
	 * @param  string  $rel
	 * @return string
	 */
	public function getPageLinkWrapper($url, $page, $rel = null)
	{
		$rel = is_null($rel) ? '' : ' rel="'.$rel.'"';

		return '<li><a href="'.$url.'"'.$rel.'>'.$page.'</a></li>';
	}

	/**
	 * Get HTML wrapper for disabled text.
	 *
	 * @param  string  $text
	 * @return string
	 */
	public function getDisabledTextWrapper($text)
	{
		return '<li><span>'.$text.'</span></li>';
	}

	/**
	 * Get HTML wrapper for active text.
	 *
	 * @param  string  $text
	 * @return string
	 */
	public function getActivePageWrapper($text)
	{
		return '<li><span class="active">'.$text.'</span></li>';
	}


	/**
	 * Get the previous page pagination element.
	 *
	 * @param  string  $text
	 * @return string
	 */
	public function getPrevious($text = '&larr;')
	{
		return parent::getPrevious($text);
	}


	/**
	 * Get the next page pagination element.
	 *
	 * @param  string  $text
	 * @return string
	 */
	public function getNext($text = '&rarr;')
	{
		return parent::getNext($text);
	}
	
}
