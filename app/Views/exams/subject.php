<?= $this->extend('page'); ?>
<?= $this->section('content'); ?>
	<div class="breadcrumb">
		<a href="/exam"><i>Сви рокови</i></a>:
	</div>
	<h1><?= $subject->name ?> (<?= $subject->code ?>)</h1>
	<div class="tableList">
		<?= $exam_table ?>
	</div>
	<?php if(session()->get('logged')): ?>
		<div class="command-block">
			<div style="margin-left: auto;"></div>
			<a href="/exam/generate/<?= $subject->id ?>" class="button bigButton">Генериши рок</a>
			<?php if(session()->get('can_add')): ?>
				<a href="/exam/new/<?= $subject->id ?>" class="button bigButton">Нови рок</a>
			<?php endif; ?>
		</div>
	<?php endif; ?>
<?= $this->endSection(); ?>