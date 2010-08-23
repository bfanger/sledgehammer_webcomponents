<?php
/**
 * Een lijst met ondersteuning voor labels <DL><DT><DD></DL>
 *
 * @package Webcomponents
 */

class DefinitionList extends Object implements Component {

	public
		$items,
		$parameters;

	function __construct($items, $parameters = array()) {
		$this->items = $items;
		$this->parameters = $parameters;
	}

	function render() {
		$labels = is_assoc($this->items);
		echo '<dl'.implode_xml_parameters($this->parameters).'>'."\n";
		foreach($this->items as $label => $values) {
			echo "\t";
			if ($labels) { // Met labels?
				echo '<dt>'.$label.'</dt>';
			}
			if (is_array($values)) {
				foreach ($values as $value) {
					$this->render_dd($value);
				}
			} else {
				$this->render_dd($values);
			}
		}
		echo '</dl>'."\n";
	}

	private function render_dd($value) {
		if (trim($value) != '') {
			echo '<dd>'.$value.'</dd>'."\n";
		} else {
			echo '<dd>&nbsp;</dd>'."\n";
		}
	}
}
?>
