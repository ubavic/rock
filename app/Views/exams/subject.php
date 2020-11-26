<main>
    <div class="breadcrumb">
        <a href="/exam"><i>Сви рокови</i></a>:
    </div>
	<h2><?= $subject->name ?> (<?= $subject->code ?>)</h2>
	<div class="tableList">
		<?= $exam_table ?>
	</div>
	<?php if($can_add): ?>
		<div class="formRow" style="flex-direction: row-reverse;">
			<a href="/exam/new" class="button bigButton">Нови рок</a>
		</div>
	<?php endif; ?>
</main>