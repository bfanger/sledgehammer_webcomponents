<?php
/**
 * Een tabel <table>
 *
 * @package Webcomponents
 */

class Table extends Object implements Component {

	public
		$template = 'Table.html',
		$headers = array(), // De vertalingen van de kolomnamen. Bij geen vertaling wordt de kolomnaam gebruikt. array('kolomnaam' => 'vertaling'); 
		$Iterator, // De inhoud van de tabel
		$footnote; // Een voetnoot aan het einde van de tabel
		

	protected		
		$columns, 
		$table_parameters,
		$column_parameters;

	/**
	 *
	 * @param array $columns De Kolommen die weergegeven worden in de tabel. vb: array('id', 'naam')
	 * @param array $table_parameters Parameters voor de <table> tag. Bv: array('class' => 'logtable')
	 * @param array $column_parameters Parameters voor de <td> tags. Bv: array('kolom2' => array('align' => 'center'))
	 */
	function __construct($columns, $table_parameters = array(), $column_parameters = array()) {
		$this->columns = $columns;
		$this->table_parameters = $table_parameters;
		$this->column_parameters = $column_parameters;
	}

	function render() {
		$column_parameters = array();
		foreach ($this->column_parameters as $key => $value) {
			$column_parameters[$key] = parse_xml_parameters($value);
		}
		$template = new Template($this->template, array(
			'table_parameters' => implode_xml_parameters($this->table_parameters),
			'headers' => $this->export_table_headers(),
			'columns' => $this->columns,
			'column_parameters' => $column_parameters,
			'rows' => $this->Iterator,
			'footnote' => $this->footnote,
		));
		$template->render();
	}
	
	protected function export_table_headers() {
		$headers = array();
		foreach ($this->columns as $column) {
			if (isset($this->headers[$column])) {
				$headers[$column] = $this->headers[$column];
			} else {
				$headers[$column] = $column;
			}
		}
		return $headers;
	}
}
?>
