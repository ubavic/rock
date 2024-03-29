<?= $this->extend('page'); ?>
<?= $this->section('content'); ?>
	<div class="breadcrumb">
		<?php if($commandBlock): ?>
			<a href="/exam/save_exam/<?= $exam->id ?>"
				title="<?= ($saved) ? 'Уклоните рок из листе сачуваних рокова.' :'Сачувајте рок.' ?>"
				class="bookmarkRibbon <?= ($saved) ? 'bookmarkRibbonSaved' : ''?>">
			</a>
		<?php endif; ?>
		<div>
			<a href="/exam"><i>Сви рокови</i></a>&nbsp;&bull;&nbsp;
			<a href="/exam/<?= $subject->id ?>"><i><?= $subject->name ?></i></a>:
		</div>
	</div>
	<div style="display: flex; flex-direction: row">
		<div style="margin-left: auto"></div>
		<div><?= $exam->date_string ?></div>
	</div>
	<h1 id="examTitle">
	<?php if ($exam->type == 0): ?>
		Писмени испит из предмета
	<?php elseif ($exam->type == 1): ?>
		Колоквијум из предмета
	<?php elseif ($exam->type === -1): ?>
		Насумично генерисан рок
	<?php endif; ?>
		<span class="class"><?= $subject->name ?></span>
	<?php if($exam->modules_string): ?>
		<?php if(strlen($exam->modules_string) > 2): ?>
			За смерове <?= $exam->modules_string ?>.
		<?php else: ?>
			За смер <?= $exam->modules_string ?>.
		<?php endif; ?>
	<?php endif; ?>
	</h1>
	<?php if($exam->duration): ?>
	<p>Време израде: <?= $exam->duration ?> минута.</p>
	<?php endif; ?>
	<?php if ($exam->note != NULL): ?>
	<p><?= $exam->note ?></p>
	<?php endif; ?>
	<div class="problems">
		<?php for ($i = 0; $i < count($problems); $i++): ?>
			<section class="problem">
				<header class="formRow">
					<h2><a href="#p<?= $i + 1 ?>" id="p<?= $i + 1 ?>"><?= $i + 1 ?></a></h2>
					<div class="verticalRowSpacer"></div>
					<?php if($problems[$i]->points != 0): ?>
					<div class="points"><?= $problems[$i]->points?> поена</div>
					<?php endif; ?>
				</header>
				<?= $problems[$i]->text ?>
			</section>
		<?php endfor;?>
	</div>
	<?php if($commandBlock): ?>
		<div class="no-print" style="font-style: italic; text-align:center; font-size: 0.9em">
			Рок додат <?= $exam->created_at ?>, од&nbsp;<?= $created_by ?>
			<?php if($exam->created_at != $exam->updated_at): ?>
				&bull; Последњи пут измењен <?= $exam->updated_at ?>, од&nbsp;<?= $updated_by ?>
			<?php endif; ?>
		</div>
		<div class="command-block">
			<a href="/exam/tex/<?= $exam->id ?>" class="button bigButton">LaTeX</a>
			<div style="margin-left:auto;"></div>
			<?php if(is_null($exam->edit_lock)): ?>
				<?php if(session()->get('can_edit')): ?>
					<a href="/exam/edit/<?= $exam->id ?>" class="button bigButton">Измени рок</a>
				<?php endif; ?>
				<?php if(session()->get('can_delete')): ?>
					<div onclick="confirmDelete()" class="button bigButton">Обриши рок</div>
				<?php endif; ?>
			<?php elseif ($exam->edit_lock == session()->get('id') || session()->get('can_manage_users')): ?>
				<a href="/exam/unlock/<?= $exam->id ?>" class="button bigButton">Откључај рок</a>
			<?php else: ?>
				<img src="/img/lock.svg" title="Рок је тренутно заључан.">
			<?php endif; ?>
		</div>
		<script type="text/javascript">
			function confirmDelete() {
				if (confirm('Да ли сте сигурни да желите да обришете овај рок?')) {
					window.location.href = '/exam/delete/<?= $exam->id ?>';
				}
			}
		</script>
	<?php endif; ?>
<?= $this->endSection(); ?>