<?= $this->extend('page'); ?>
<?= $this->section('content'); ?>
	<h1>Сви предмети</h1>
	<div class="tableList">
		<div class="tableListHeader">
			<div style="width: 4em">Шифра</div>
			<div style="flex-grow: 2;">Предмет</div>
		</div>
		<?php foreach ($subjects as $subject): ?>
			<a class="tableListRow" href="/subject/<?= $subject->id ?>">
				<div style="width: 4em"><?= $subject->code; ?></div>
				<div style="flex-grow: 2;"><?= $subject->name; ?></div>
			</a>
		<?php endforeach; ?>
	</div>
	<?php if(session()->get('logged')): ?>
		<?php if(session()->get('can_manage_subjects')): ?>
			<div class="formRow no-print" style="flex-direction: row-reverse;">
				<a href="/subject/new" class="button bigButton">Додај предмет</a>
			</div>
		<?php endif; ?>
	<?php endif; ?>
<?= $this->endSection(); ?>