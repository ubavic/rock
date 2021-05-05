<?= $this->extend('page'); ?>
<?= $this->section('content'); ?>
	<h1 style="margin-top:0">Сачувани рокови</h1>
	<p>У следећој листи налазе се сви рокови које сте до сада сачували.</p>
	<div class="tableList">
		<?= $exam_table ?>
	</div>
<?= $this->endSection(); ?>