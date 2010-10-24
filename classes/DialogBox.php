<?php
/**
 * Een component waarmee je een vraag kunt stellen, en antwoord krijgt ;) 
 *
 * Compatible met de Import interface uit de Forms module 
 * @package Webcomponents
 */

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
			'form_action' => URL::uri(),
			'identifier' => $this->identifier,
			'answers' => $answers,
		));
		$template->render();
	}

	/*
	// Een Dialoog opbouwen met veel voorkomende opties.
	// $types: 'delete', 'warning', 
	static function build($type, $question = NULL, $title = NULL) {

		$icon = strtolower($type).'.gif'; // De afbeeldingen hebben vaak dezelfde naam als het type

		switch ($type) { // Op basis van het type 

			case 'delete':
				$default_title = 'Verwijder bevestiging';
				$default_question = 'Weet je zeker dat je het item wilt verwijderen?';
				$answers = array('yes' => array('icon' => 'ok.gif', 'label' => 'Ja'), 'no.gif' => array('icon' => 'cancel', 'label' => 'Nee'));
				break;

			case 'warning':
				$default_title = 'Waarschuwing';
				$default_question = 'Weet je zeker dat je wilt doorgaan?';
				$answers = array('continue' => array('icon' => 'continue.gif', 'label' => 'Doorgaan'), 'cancel' => array('icon' => 'cancel.gif', 'label' => 'Annuleren'));
				break;

			default:
  			warning('Unexcpected dialog-type: "'.$type.'", expecting "delete" or "warning"');
				return false;
		}
		if($title === NULL) { 
			$title	= $default_title; 
		}
		if($question === NULL) { 
			$question	= $default_question; 
		}
		return new DialogBox($icon, $title, $question, $answers);
	}
	 */
}
?>
