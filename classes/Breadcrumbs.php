<?php
/**
 * Breadcrumb Navigation
 * D.m.v. van static add() function kun je crumbs toevoegen. Hierdoor kan het component vanuit alle php bestanden gevuld worden. 
 * Zelfs als de Breadcrumbs nergens getoond zal worden kunnen Commands & VirtualFolder gebruik maken van deze class.
 *
 * @package Webcomponents
 */

class Breadcrumbs extends Object implements Component {

	private $identfier; // De idenfier die bepaalt welke crumbs bij dit component horen 
	private static $crumbs = array(); // format: array('identfier' => array('url' => url, 'label' => label))
	static $active = 'default'; // De Breadcrumb::add() voegt de crumb toe aan deze identfier

	function __construct($identfier = 'default') {
		$this->identfier = $identfier;
	}

	static function add($label, $url = NULL) {
		self::$crumbs[self::$active][] = array('url' => $url, 'label' => $label);
	}

	function render() {
		$breadcrumbs = array();
		if (!isset(self::$crumbs[self::$active])) {
			self::$crumbs[self::$active] = array();
		}
		foreach (self::$crumbs[$this->identfier] as $crumb) {
			if ($crumb['url']) {
				$breadcrumbs[] = '<a href="'.htmlentities($crumb['url']).'">'.$crumb['label'].'</a>';
			} else {
				$breadcrumbs[] = $crumb['label'];
			}
		}
		$template = new Template('Breadcrumbs.html', array('breadcrumbs' => $breadcrumbs));
		$template->render();
	}
}
?>
