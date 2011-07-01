<?php
/**
 * Een tabel waar er op de records geklikt kan worden
 *
 * @package Webcomponents
 */
namespace SledgeHammer;
class InteractiveTable extends Table {

	public 
		$order_by;

	private 
		$url_prefix,
		$url_suffix,
		$identifier;

	function __construct($columns, $url_prefix, $url_suffix = '', $order_by = false, $identifier = 'order_by', $table_parameters = array(), $column_parameters = array()) {
		parent::__construct($columns, $table_parameters, $column_parameters);
		$this->url_prefix = $url_prefix;
		$this->url_suffix = $url_suffix;
		$this->order_by = $order_by;
		$this->identifier = $identifier;
		$this->template = 'InteractiveTable.html';
	}

	function render() {
		$headers_backup = $this->headers;
		$url_prefix = substr(URL::info('path').'?'.http_build_query(URL::parameters($this->identifier)), 0, -1);
		if ($this->order_by) {
			$selected = key($this->order_by);
		} else {
			$selected = NULL;
		}
		$header_parameters = array();
		foreach ($this->columns as $column => $parameters) {
			if (!is_array($parameters)) {
				$column = $parameters;
			}
			$direction = 'ASC';
			if ($column == $selected) {
				if (!isset($this->headers[$column])) {
					$this->headers[$column] = $column;
				}
				$this->headers[$column] = $this->headers[$column].'<img src="/images/'.strtolower($this->order_by[$selected]).'.gif" class="order_by" alt="'.($this->order_by[$selected] == 'ASC' ? ' ^' : ' v').'" />';
				$direction = $this->order_by[$selected] == 'ASC' ? 'DESC' : 'ASC';
			}
			$header_parameters[] = ' onClick="document.location.href=\''.htmlentities($url_prefix.'['.$column.']='.$direction).'\'"';
		}
		$GLOBALS['Smarty']->assign(array(
			'url_prefix' => $this->url_prefix,
			'url_suffix' => $this->url_suffix,
			'header_parameters' => $header_parameters,
		));
		parent::render();
		$this->headers = $headers_backup;
	}
}
?>
