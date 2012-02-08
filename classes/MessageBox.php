<?php
/**
 * MesageBox, a modal popup.
 * Compatible with Twitter Bootrap css and $().modal()
 *
 * @package Webcomponents
 */

namespace SledgeHammer;

class MessageBox extends Object implements View {

	/**
	 * @var string
	 */
	private $title;

	/**
	 * @var string
	 */
	private $body;

	/**
	 * @param string $title
	 * @param string $body HTML
	 */
	function __construct($title, $body) {
		$this->title = $title;
		$this->body = $body;
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
		echo '</div>';
	}

	static function warning($title, $message) {
		$icon = '<img style="float:left;margin: 0px 15px 15px 0" src="'.WEBROOT.'mvc/img/warning.png" alt="WARNING" />';
		return new MessageBox($title, $icon.'<p>'.HTML::escape($message).'</p>');
	}

	static function error($title, $message) {
		$icon = '<img style="float:left;margin: 0px 15px 15px 0" src="'.WEBROOT.'mvc/img/error.png" alt="ERROR" />';
		return new MessageBox($title, $icon.'<p>'.HTML::escape($message).'</p>');
	}

}

?>
