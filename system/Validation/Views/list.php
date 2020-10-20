<?php if (! empty($errors)) : ?>
	<div class="errors" role="alert">
		<?php foreach ($errors as $error) : ?>
			<?= esc($error) ?></br>
		<?php endforeach ?>
	</div>
<?php endif ?>
