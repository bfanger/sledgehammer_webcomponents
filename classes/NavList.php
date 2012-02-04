<?php
/**
 * Een lijst met acties(links) met iconen(optioneel)
 *
 * @package Webcomponents
 */
namespace SledgeHammer;
class NavList extends Object implements View {

	public
		$title,
		$actions; // formaat: array(url => label, ...) of array(url => array('icon' => icon_url, 'label' => label))

	function __construct($actions, $title = null) {
		$this->actions = $actions;
		$this->title = $title;
	}

	function render() {
		$actions = array();
		if ($this->title !== null) {
			$actions[]['header'] = $this->title;
		}
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
		$template = new Template('NavList.php', array('actions' => $actions));
		$template->render();
	}
}
?>
