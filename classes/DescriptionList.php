<?php
/**
 * A Description lists <dl><dt><dd></dl>
 *
 * @package Webcomponents
 */
namespace SledgeHammer;
class DescriptionList extends Object implements View {

	private $items;
	private $attributes;

	function __construct($items, $attributes = array()) {
		$this->items = $items;
		$this->attributes = $attributes;
	}

	function render() {
		echo HTML::element('dl', $this->attributes, true);
		foreach($this->items as $label => $values) {
			echo "\t";
			echo HTML::element('dt', array(), $label);
			if (is_array($values)) {
				foreach ($values as $value) {
					echo HTML::element('dd', array(), $value);
				}
			} else {
				echo HTML::element('dd', array(), $values);
			}
		}
		echo '</dl>'."\n";
	}
}
?>
