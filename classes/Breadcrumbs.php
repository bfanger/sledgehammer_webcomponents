<?php
/**
 * Breadcrumb Navigation
 * D.m.v. van static add() function kun je crumbs toevoegen. Hierdoor kan het component vanuit alle php bestanden gevuld worden.
 * Zelfs als de Breadcrumbs nergens getoond zal worden kunnen Commands & VirtualFolder gebruik maken van deze class.
 *
 * @package Webcomponents
 */
namespace SledgeHammer;
class Breadcrumbs extends Object implements View {

	private $divider;
	private $identfier; // De idenfier die bepaalt welke crumbs bij dit component horen
	private static $crumbs = array(); // format: array('identfier' => array('url' => url, 'label' => label))
	static $active = 'default'; // De Breadcrumb::add() voegt de crumb toe aan deze identfier

	function __construct($identfier = 'default', $divider = '&raquo') {
		$this->identfier = $identfier;
		$this->divider = $divider;
	}

	/**
	 *
	 * @param string|array $crumb
	 * @param string $url
	 */
	static function add($crumb, $url = null) {
		if (is_array($crumb) == false) {
			$crumb = array(
				'label' => $crumb,
			);
		}
		$crumb['url'] = $url;
		self::$crumbs[self::$active][] = $crumb;
	}

	function render() {
		if (!isset(self::$crumbs[self::$active])) {
			self::$crumbs[self::$active] = array();
		}
		$template = new Template('Breadcrumbs.php', array('breadcrumbs' => self::$crumbs[$this->identfier], 'divider' => $this->divider));
		$template->render();
	}
}
?>
