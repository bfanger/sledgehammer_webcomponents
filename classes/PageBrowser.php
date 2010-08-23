<?php
/**
 * << 1 2 3 [4] 5 6 10-20 >>
 * Oftewel de balk die onderaan de (zoek)resultaten staat om door de resultaten te bladeren  
 *
 * @package Webcomponents
 */

class PageBrowser extends Object implements Component {

	public
		$page_count,
		$current_page,
		$url_prefix,
		$url_suffix,
		$offset = 10; // het aantal pagina's dat getoont wordt naast de geselecteerde pagina

	function __construct($page_count, $current_page, $url_prefix = NULL, $url_suffix = NULL) {
		$this->page_count = ceil($page_count);
		$this->current_page = $current_page;
		if ($url_prefix) {
			$this->url_prefix = $url_prefix;
		} else {
			$this->url_prefix = URL::info('path').'?'.http_build_query(URL::parameters('page='));
		}
		$this->url_suffix = $url_suffix;
	}

	function render() {
		if ($this->page_count == 0) {
			return;
		}
		$pages = array();
		$start = 1;
		$end = $this->page_count;
		$prefix = htmlentities($this->url_prefix);
		$suffix = htmlentities($this->url_suffix);
		if ($this->page_count > (($this->offset * 2) + 1)) { // Past het aantal pagina's dermate groot dat het niet mooi meer op de pagina past? 
			$offset_left = $this->offset;
			$offset_right = $this->offset;
			if ($this->current_page <= $this->offset) { // is de offset niet nodig aan de linkerkant?
				$offset_right = ($this->offset * 2) - $this->current_page + 1; // dan de rechterkant aanvullen
			} 
			if (($this->current_page + $offset_right) >= $this->page_count) { // is de offset niet nodig aan de rechterkant?
				$offset_left = ($this->offset * 2) + ($this->current_page - $this->page_count);//($this->offset * 2) + $this->current_page + 1; // dan de rechterkant aanvullen
			}
			if ($this->current_page > $offset_left) {
				$start = $this->current_page - $offset_left;
			}
			if (($this->current_page + $offset_right) < $this->page_count) {
				$end = $this->current_page + $offset_right;
			}
		}
		for ($i = $start; $i <= $end; $i++) {
			if ($i == $this->current_page) {
				$pages[$i] = array(
					'selected' => true,
				);
			} else {
				$pages[$i] = array(
					'selected' => false,
					'url' => $prefix.$i.$suffix
				);
			}
		}
		$template = new Template('PageBrowser.html', array(
			'first' => ($this->current_page != 1) ? $prefix.'1'.$suffix : false,
			'previous' => ($this->current_page != 1) ? $prefix.($this->current_page - 1).$suffix : false,
			'pages' => $pages,
			'next' => ($this->current_page != $this->page_count) ? $prefix.($this->current_page + 1).$suffix : false,
			'last' => ($this->current_page != $this->page_count) ? $prefix.$this->page_count.$suffix : false,
			'count' => $this->page_count
		));
		$template->render();
	}
}
?>
