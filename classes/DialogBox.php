<?php
/**
 * Een component waarmee je een vraag kunt stellen, en antwoord krijgt ;) 
 *
 * Compatible met de Import interface uit de Forms module 
 * @package Webcomponents
 */
namespace SledgeHammer;
class DialogBox extends Object implements Component {

	public 
		$identifier,
		$answers;

	private
		$icon,
		$title,
		$question;

	function __construct($icon, $title, $question, $answers, $identifier = 'dialog_anwser') {
		$this->identifier = $identifier;
		if (in_array($icon, array('warning', 'error'))) {
			$icon = WEBROOT.'mvc/icons/MessageBox/'.$icon.'.png';
		}
		$this->icon = $icon;
		$this->title = $title;
		$this->question = $question;
		$this->answers = $answers;
	}

	function initial($null) {
		error('DialogBox doesn\'t support a default option');
	}

	function import(&$error_message, $source = NULL) {
		if (extract_element($_POST, $this->identifier, $answer)) {
		} else {
			$error_message = false; // De foutmelding onderdrukken, hoogstwaarschijnlijk is het dialoog venster nog niet getoond.
			return NULL;
		}
		if (isset($this->answers[$answer])) {
			return $answer;
		} else {
			$error_message = 'Unexpected anwser "'.$answer.'", expecting "'.implode(', ', array_keys($this->answers)).'"';
			return NULL;
		}
	}

	function getHeaders() {
		return array(
			'title' => $this->title
		);
	}

	function render() {
		foreach($this->answers as $answer => $button) {
			if (is_array($button)) { // button met icoon?
				$answers[] = array(
					'value' => $answer,
					'icon' => $button['icon'],
					'label' => $button['label']
				);
			} else { // zonder icoon
				$answers[] = array(
					'value' => $answer,
					'label' => $button
				);
			}
		}
		$template = new Template('DialogBox.html', array(
			'title' => $this->title,
			'icon' => $this->icon,
			'question' => $this->question,
			'form_action' => URL::getCurrentURL(),
			'identifier' => $this->identifier,
			'answers' => $answers,
		));
		$template->render();
	}
}
?>