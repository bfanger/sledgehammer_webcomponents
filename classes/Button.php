<?php
namespace SledgeHammer;

/**
 * Button, generate
 */
class Button extends Object implements View {

	/**
	 * @var String
	 */
	private $label;

	/**
	 * @var type
	 */
	private $icon;

	/**
	 * @var string Determine the element type (a|button|input)
	 */
	private $element = 'button';

	/**
	 * @var array Additional attributes
	 */
	private $attributes = array(
		'class' => 'btn'
	);

	function __construct($label_or_options, $options = array()) {
		if (is_array($label_or_options) === false) {
			$options['label'] = $label_or_options;
		} else {
			if (count($options) !== 0) {
				notice('Second parameter $options is ignored');
			}
			$options = $label_or_options;
		}
		$properties = array('label', 'icon', 'element');
		$attributes = array('id', 'type', 'name', 'value', 'class');

		foreach ($options as $option => $value) {
			if (in_array($option, $attributes)) {
				$this->attributes[$option] = $value;
			} elseif (in_array($option, $properties)) {
				$this->$option = $value;
			} else {
				notice('Option: "'.$option.'" not supported');
			}
		}
	}

	function render() {
		$attributes = $this->attributes;
		switch ($this->element) {

			case 'button';
				break;

		}
		if ($this->icon) {
			$label = HTML::icon($this->icon).' '.HTML::escape($this->label);
		} else {
			$label = HTML::escape($this->label);
		}
		echo HTML::element($this->element, $attributes, $label);
	}

	function __toString() {
		return export_view($this);
	}

}

?>
