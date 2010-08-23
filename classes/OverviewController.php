<?php
/**
 * Omschrijving : Verzorgt de PageBrowser,de footnoot en sorteermogelijkheden van diverse overzichten
 *
 * @package Webcomponents
 */

class OverviewController extends Object implements Command {

	public
		$Table;

	private
		$name,
		$SQLComposer,
		$identifier,
		$database_link,
		$per_page_default,
		$row_count;

	function __construct($SQLComposer, $name, $row_count, $identifier = 'id', $database_link = 'default', $per_page_default = 20) {
		$this->SQLComposer = $SQLComposer;
		$this->name = $name;
		$this->row_count = $row_count;
		$this->identifier = $identifier;
		$this->database_link = $database_link;
		$this->per_page_default = $per_page_default;
	}

	function execute() {
		if ($this->row_count == 0) {
			$GLOBALS['Viewport'] = new MessageBox('warning.gif', 'Geen '.$this->name.' gevonden', 'Er zijn geen '.$this->name.' gevonden, pas het eisenpakket aan en probeer opnieuw.');
			return false;
		}
		if ($this->Table === NULL) {
			warning('Invalid $this->Table, Table of InteractiveTable object expected');
			return false;
		}
		$GLOBALS['Viewport'] = new Template('overview.html');
		$page = 1;
		if (isset($_GET['page'])) {
			$page = $_GET['page'];
		}
		$per_page = $this->per_page_default;
		if (isset($_GET['per_page'])) {
			$per_page = $_GET['per_page'];
		}
		if ($this->row_count > $this->per_page_default) {
			$GLOBALS['Viewports']['page_browser'] = new PageBrowser($this->row_count / $per_page, $page);
		}

		$first_record = ($page - 1) * $per_page + 1; // Berekenen welke rij er getoond wordt
		$last_record = $first_record + $per_page - 1;
		if ($last_record > $this->row_count) {
			$last_record = $this->row_count;
		}

		if (isset($_GET['order_by'])) {
			$this->SQLComposer->order_by = $_GET['order_by'];
			$this->Table->order_by = $_GET['order_by'];
		}
		$this->SQLComposer->limit = array(
			'offset' => ($page - 1) * $per_page,
			'count' => $per_page
		);
		$Database = database($this->database_link);
		$this->Table->footnote = $first_record.' t/m '.$last_record.' van '.$this->row_count.' '.$this->name;
		$this->Table->Iterator = $Database->query($this->SQLComposer->compose(), $this->identifier);
		$GLOBALS['Viewports']['table'] = $this->Table;
		return true;
	}
}
?>
