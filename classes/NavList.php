<?php
/**
 * Nav lists - Application-style navigation
 *
 * @package Webcomponents
 */

namespace SledgeHammer;

class NavList extends Object implements View {

	/**
	 * @var array
	 */
	private $items;

	/**
	 * @param array $items format: array(url => label, ...) of array(url => array('icon' => icon_url, 'label' => label))
	 */
	function __construct($items) {
		$this->items = $items;
	}

	function render() {
		echo "<ul class=\"nav nav-list\">\n";
		foreach ($this->items as $url => $action) {
			if (is_int($url)) {
				echo "\t<li class=\"nav-header\">".HTML::escape($action)."</li>\n";
			} else {
				echo "\t<li><a href=\"".$url.'">';
				if (is_array($action)) { // link met icoon?
					echo HTML::icon($action['icon']), ' ', HTML::escape($action['label']);
				} else { // link zonder icoon
					echo HTML::escape($action);
				}
				echo "</a></li>\n";
			}
		}
		echo '</ul>';
	}

}

?>
