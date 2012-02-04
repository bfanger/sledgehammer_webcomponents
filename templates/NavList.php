<?php
/**
 * Een lijst met links
 */
namespace SledgeHammer;
?>
<ul class="nav nav-list">
<?php
foreach ($actions as $link) {
	if (isset($link['header'])) {
		echo "\t<li class=\"nav-header\">".HTML::escape($link['header'])."</li>\n";
		continue;
	}
	echo "\t<li><a href=\"".$link['url'].'">';

	if (isset($link['icon'])) {
		echo HTML::icon($link['icon']), ' ';
	}
	echo $link['label'].'</a></li>'."\n";


}
?>
</ul>
