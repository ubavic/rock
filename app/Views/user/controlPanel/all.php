<?= $this->extend('user/controlPanel/layout'); ?>
<?= $this->section('cp_content'); ?>
	<div>
		<h2 style="margin-top:0">Сви корисници</h2>
		<div class="tableList">
			<div class="tableListHeader">
				<div>Корисник</div>
			</div>
			<?php foreach ($users as $user): ?>
				<a href="/user/<?= $user->id; ?>" class="tableListRow">
					<div><?= $user->name; ?></div>
				</a>	
			<?php endforeach; ?>
		</div>
	</div>
<?= $this->endSection(); ?>