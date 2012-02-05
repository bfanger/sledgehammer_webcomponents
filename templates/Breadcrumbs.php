<?php
/**
 * Breadcrumb navigation
 */

namespace SledgeHammer;

echo "<ul class=\"breadcrumb\">\n";
$breadcrumbs[count($breadcrumbs) - 1]['last'] = true;
foreach ($breadcrumbs as $crumb) {
	echo "\t<li>";
	if (isset($crumb['icon'])) {
		$label = HTML::icon($crumb['icon']).' '.HTML::escape($crumb['label']);
	} else {
		$label = HTML::escape($crumb['label']);
	}
	if ($crumb['url']) {
		echo HTML::element('a', array('href' => $crumb['url']), $label);
	} else {
		echo $label;
	}
	if (empty($crumb['last'])) {
		echo ' <span class="divider">'.$divider.'</span>';
	}
	echo "</li>\n";
}
echo "</ul>\n";
?>