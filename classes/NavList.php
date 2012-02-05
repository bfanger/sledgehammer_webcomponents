<?php
/**
 * Nav lists - Application-style navigation
 *
 * @package Webcomponents
 */
namespace SledgeHammer;
class NavList extends Object implements View {

	public
		$actions; // format: array(url => label, ...) of array(url => array('icon' => icon_url, 'label' => label))

	function __construct($actions) {
		$this->actions = $actions;
	}

	function render() {
		$actions = array();
		foreach($this->actions as $url => $action) {
			if (is_int($url)) {
				$actions[] = array(
					'header' => $action,
				);
			} elseif (is_array($action)) { // link met icoon?
				$actions[] = array(
					'url' => $url,
					'icon' => $action['icon'],
					'label' => $action['label'],
				);
			} else { // link zonder icoon
				$actions[] = array(
					'url' => $url,
					'label' => $action,
				);
			}
		}
		$template = new Template('NavList.php', array('actions' => $actions));
		$template->render();
	}
}
?>
