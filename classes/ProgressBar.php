<?php
/**
 * Een balk die de voortgang toont
 *
 * @package Webcomponents
 */
namespace SledgeHammer;
class ProgressBar extends Object implements View {

	public
		$value,
		$width = 300;

	private
		$maximum,
		$minimum;

	function __construct($maximum = 100, $value = 0, $minimum = 0) {
		$this->maximum = $maximum;
		$this->value = $value;
		$this->minimum = $minimum;
	}

	function render() {
		$factor = ($this->value - $this->minimum) / ($this->maximum - $this->minimum);
		$GLOBALS['Smarty']->assign(array(
			'value' => $this->value,
			'maximum' => $this->maximum,
			'percentage' => floor($factor * 1000) / 10,
			// Omgerekende waarden
			'width' => $this->width,
			'done' => floor($this->width * $factor),
			'remaining' => ceil($this->width - ($this->width * $factor)),
		));
		$GLOBALS['Smarty']->display('ProgressBar.html');
	}
}
?>
