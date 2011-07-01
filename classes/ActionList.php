<?php
/**
 * Een lijst met acties(links) met iconen(optioneel)
 *
 * @package Webcomponents
 */
namespace SledgeHammer;
class ActionList extends Object implements Component {

	public
		$actions; // formaat: array(url => label, ...) of array(url => array('icon' => icon_url, 'label' => label))

	function __construct($actions) {
		$this->actions = $actions;
	}

	function render() {
		$actions = array();
		foreach($this->actions as $url => $action) {
			if (is_array($action)) { // link met icoon?
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
		$template = new Template('ActionList.html', array('actions' => $actions));
		$template->render();
	}
}
?>
