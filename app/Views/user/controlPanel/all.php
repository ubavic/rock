<?= $this->extend('user/controlPanel/layout'); ?>
<?= $this->section('content'); ?>
	<div>
		<h3 style="margin-top:0">Сви корисници</h3>
		<div class="tableList">
			<div class="tableListHeader">
				<div>Корисник</div>
			</div>
			<?php foreach ($users as $user): ?>
				<div class="tableListRow">
					<div><?= $user->user_link; ?></div>
				</div>	
			<?php endforeach; ?>
		</div>
	</div>
<?= $this->endSection(); ?>