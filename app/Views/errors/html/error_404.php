<?= $this->extend('page'); ?>
<?= $this->section('content'); ?>
	<h1>404 - <i>File Not Found</i></h1>
	<p>
		<?php if (! empty($message) && $message !== '(null)') : ?>
			<?= esc($message) ?>
		<?php else : ?>
			Не можемо да пронађемо страницу коју сте затражили.
		<?php endif ?>
	</p>
<?= $this->endSection(); ?>
