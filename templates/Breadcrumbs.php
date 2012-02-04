<?php
/**
 * Horizontal breadcrumbs navigation
 */
?>
<div class="breadcrumb">
<?php
	echo implode('</span> <span class="divider">&raquo;</span> </span>', $breadcrumbs);
?>
</div>
