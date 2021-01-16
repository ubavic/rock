<main>
	<h1>Претражи рокове</h1>
	<div class="tableList">
		<div class="tableListHeader">
			<div style="width: 4em">Шифра</div>
			<div style="flex-grow: 2;">Предмет</div>
			<div>Укупно рокова</div>
		</div>
		<?php foreach ($subject_list as $subject): ?>
			<a class="tableListRow" href="/exam/<?= $subject->id ?>">
				<div style="width: 4em"><?= $subject->code; ?></div>
				<div style="flex-grow: 2;"><?= $subject->name; ?></div>
				<div><?= $subject->count; ?></div>
			</a>	
		<?php endforeach; ?>
	</div>
	<?php if($can_add): ?>
		<div class="formRow" style="flex-direction: row-reverse;">
			<a href="/exam/new" class="button bigButton">Нови рок</a>
		</div>
	<?php endif; ?>
</main>