<?= $this->extend('page'); ?>
<?= $this->section('content'); ?>
    <div class="breadcrumb">
        <a href="/exam"><i>Сви рокови</i></a>:
    </div>
	<h1><?= $subject->name ?> (<?= $subject->code ?>)</h1>
	<div class="tableList">
		<?= $exam_table ?>
	</div>
	<?php if($can_add): ?>
		<div class="formRow no-print" style="flex-direction: row-reverse;">
			<a href="/exam/new/<?= $subject->id ?>" class="button bigButton">Нови рок</a>
		</div>
	<?php endif; ?>
<?= $this->endSection(); ?>