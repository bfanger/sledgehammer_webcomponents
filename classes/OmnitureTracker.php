<?php
/**
 * Verzorgt de invulling van de omniture tracker. Dit is het stukje javascript dat onderaan de pagina wordt ingeladen.
 * Voor het javascript bestand wordt een "create('Template', array('account' => '[accountnaam]');" gebruikt
 *
 * @package Webcomponents
 */
namespace SledgeHammer;
class OmnitureTracker extends Object implements Component {

	public 
		$pageName, // [NULL|string] De pagina titel bij omniture geregistreerd wordt. Wordt automatisch ingesteld op $Document->title, tenzij hij hetzelfde is als de $default_title
		$products = array(); // array('product1' => array('property1','property2'))

	private
		$default_title, // [string]
		$channel, // [string]
		$dynamic_properties = array(); // Extra variabelen, zoals purchaseID, eVar

	// $default_title: De waarde die pageName niet automatisch mag worden.
	function __construct($default_title) {
		$this->default_title = $default_title;
	}

	// Stelt het channel/Kanaal in van de Tracker
	// $keep_existing: [bool] false: overschrijft de vorige waarde. true: Als er een waarde is ingesteld wordt deze niet overschreven. Zodat het voorgaande kanaal leidend is (denk aan partners)
	function channel($channel, $keep_existing = false) {
		if ($this->channel === NULL || !$keep_existing) {
			$this->channel = $channel;
		}
	}

	// Werkt net als de Smarty->assign() 
	// $name_or_array: naam van de variabele of een assoc array
	// $value: waarde van de variabele
	function assign($name_or_array, $value = NULL) {
		if (is_array($name_or_array)) { // array?
			$this->dynamic_properties = array_merge($this->dynamic_properties, $name_or_array);
		} else { // name
			$this->dynamic_properties[$name_or_array] = $value;
		}
 	}

	function render() {
		if (!$this->channel) {
			notice('Unknown omniture channel');
			$this->channel = 'Onbekend';
		}
		if ($this->pageName === NULL) {
			if ($GLOBALS['Document']->title == $this->default_title) { // Heeft deze pagina geen eigen (unieke) titel?
				notice('Unknown omniture pageName');
				$pageName = 'Onbekend';
			} else {
				$pageName = $GLOBALS['Document']->title;
			}
		} else {
			$pageName = $this->pageName;
		}
		if ($GLOBALS['Document']->title == '404 - Not Found') {
			$pageName = 'ERROR 404';
			$this->dynamic_properties['pageType'] = 'errorPage';
		}
		$products = array();
		foreach ($this->products as $product) {
			$properties = '';
			foreach ($product as $property) {
				$properties .= ';'.$property;
			}
			$products[] = $properties;
		}
		$products = implode(',', $products);
		$GLOBALS['Smarty']->assign(array(
			'channel' => $this->channel,
			'pageName' => $pageName,
			'server' => php_uname('n'),
			'products' => $products,
			'dynamic_properties' => $this->dynamic_properties,
		));
		$GLOBALS['Smarty']->display('OmnitureTracker.html');
	}
}
?>
