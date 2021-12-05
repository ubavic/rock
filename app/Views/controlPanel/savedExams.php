<?= $this->extend('controlPanel/layout'); ?>
<?= $this->section('cp_content'); ?>
	<div>
        <h2 style="margin-top:0">Сачувани рокови</h2>
	    <p>У следећој листи налазе се сви рокови које сте до сада сачували.</p>
	    <div class="tableList">
		    <?= $exam_table ?>
	    </div>
	</div>
<?= $this->endSection(); ?>