<div class="DialogBox">
	<img style="float:left;margin: 0 15px 15px 0" src="<?php echo $icon; ?>" alt="" />
	<h1 class="DialogBoxContent"><?php echo $title; ?></h1>
	<p class="DialogBoxContent"><?php echo $question; ?></p>
	<form action="<?php echo $form_action; ?>" method="post">
		<?php
		foreach ($answers as $answer) {
			echo '<button type="submit" class="btn" name="'.$identifier.'" value="'.$answer['value'].'">';
			if ($answer['icon']) {
				echo SledgeHammer\HTML::icon($answer['icon']);
			}
			echo $answer['label'].'</button>';
		}
		?>
	</form>
</div>
