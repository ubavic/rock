<?= $this->extend('user/controlPanel/layout'); ?>
<?= $this->section('content'); ?>
	<div>
		<h3 style="margin-top:0">Списак пријављивања</h3>
		<div class="tableList">
			<div class="tableListHeader">
				<div style="width:10em;">Корисник</div>
				<div style="width:12em;">Време</div>
				<div style="width:10em;">Адреса</div>
			</div>
			<?php foreach ($logs as $entry): ?>
				<div class="tableListRow">
					<div style="width:10em;"><?= $entry->user_link; ?></div>
					<div style="width:12em; font-family: var(--mono-font-stack);"><?= $entry->time; ?></div>
					<div style="width:10em; font-family: var(--mono-font-stack);"><?= $entry->ip; ?></div>
				</div>	
			<?php endforeach; ?>
	</div>
<?= $this->endSection(); ?>