<?php
/**
 * DialogBox, a modal popup dialog with where selected choice is posted back the server.
 * Compatible with Twitter Bootrap css and $().modal()
 *
 * @package Webcomponents
 */

namespace SledgeHammer;

class DialogBox extends Object implements View {

	private $title;
	private $body;
	private $choices;
	private $identifier = 'answer';
	private $method = 'post';

	/**
	 *
	 * @param string $title
	 * @param string $body html
	 * @param array $choices
	 * @param array $options [optional]
	 */
	function __construct($title, $body, $choices, $options = array()) {
		$this->title = $title;
		$this->body = $body;
		$this->choices = $choices;
		foreach ($options as $option => $value) {
			$this->$option = $value;
		}
	}

	function initial($null) {
		throw new \Exception('DialogBox doesn\'t support a default option');
	}

	function import(&$error_message, $source = null) {
		if (extract_element($_POST, $this->identifier, $answer) == false) {
			$error_message = false;
			return null;
		}
		if (isset($this->choices[$answer])) {
			return $answer;
		} else {
			$error_message = 'Unexpected anwser "'.$answer.'", expecting "'.implode(', ', array_keys($this->choices)).'"';
			return null;
		}
	}

	function getHeaders() {
		return array(
			'title' => $this->title
		);
	}

	function render() {
		echo "<div class=\"modal\">\n";
		echo "\t<div class=\"modal-header\">";
		echo '<h3>', HTML::escape($this->title), "</h3></div>\n";
		echo "\t<div class=\"modal-body\">\n\t\t", $this->body, "\n\t</div>\n";
		echo "\t<div class=\"modal-footer\"><form action=\"".URL::getCurrentURL()."\" method=\"".$this->method."\">\n";
		foreach (array_reverse($this->choices) as $answer => $choice) {
			if (is_array($choice) === false) {
				$choice = array('label' => $choice);
			}
			$choice['type'] = 'submit';
			$choice['name'] = $this->identifier;
			$choice['value'] = $answer;
			$button = new Button($choice);
			echo "\t\t", $button, "\n";
		}
		echo "\t</form></div>\n";
		echo '</div>';
	}

}

?>