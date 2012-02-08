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

	function import(&$error_message, $source = NULL) {
		if (extract_element($_POST, $this->identifier, $answer)) {

		} else {
			$error_message = false; // De foutmelding onderdrukken, hoogstwaarschijnlijk is het dialoog venster nog niet getoond.
			return NULL;
		}
		if (isset($this->choices[$answer])) {
			return $answer;
		} else {
			$error_message = 'Unexpected anwser "'.$answer.'", expecting "'.implode(', ', array_keys($this->choices)).'"';
			return NULL;
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
		foreach ($this->choices as $answer => $choice) {
			$attributes = array(
				'type' => 'submit',
				'class' => 'btn',
				'name' => $this->identifier,
				'value' => $answer
			);
			if (is_array($choice)) {
				$label = HTML::escape($choice['label']);
				if ($choice['icon']) {
					$label = HTML::icon($choice['icon']).' '.$label;
				}
			} else {
				$label = HTML::escape($choice);
			}
			echo "\t\t", HTML::element('button', $attributes, $label), "\n";
		}
		echo "\t</form></div>\n";
		echo '</div>';
	}

}

?>