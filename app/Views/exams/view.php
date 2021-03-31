<?= $this->extend('page'); ?>
<?= $this->section('content'); ?>
	<div class="breadcrumb">
        <a href="/exam"><i>Сви рокови</i></a> &bull;
		<a href="/exam/<?= $subject->id ?>"><i><?= $subject->name ?></i></a>:
    </div>
	<div style="display: flex; flex-direction: row">
		<div style="margin-left: auto"></div>
		<div><?= $exam->date_string ?></div>
	</div>
	<h1 id="examTitle">
	<?php if ($exam->type == 0): ?>
		Писмени испит из предмета
	<?php else: ?>
		Колоквијум из предмета
	<?php endif; ?>
		<span class="class"><?= $exam->subject_name ?></span>
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
	<?php if(session()->get('logged')): ?>
		<?php 
			$uri = service('uri');
			$uri->setSilent();
		?>
		<div class="formRow" style="align-items: flex-end;">
			<div style="font-style: italic; font-size: 0.9em">
				Рок додат <?= $exam->created_at ?>, од <?= $created_by ?>.
				<?php if($exam->created_at != $exam->updated_at): ?>
					<br>Последњи пут измењен <?= $exam->updated_at ?>, од <?= $updated_by ?>.
				<?php endif; ?>
			</div>
			<div style="margin-left:auto;"></div>
			<?php if($can_edit): ?>
				<a href="/exam/edit/<?= $uri->getSegment(3) ?>" class="button bigButton">Измени рок</a>
			<?php endif; ?>
			<?php if($can_delete): ?>
            	<div onclick="<?= 'confirmDelete(\'/exam/delete/' . $exam->id .'\')'?>" class="button bigButton">Обриши рок</div>
				<script type="text/javascript">
					function confirmDelete(url) {
						if (confirm('Да ли сте сигурни да желите да обришете овај рок?')) {
							window.location.href = url;
						}
					}
				</script>
			<?php endif; ?>
        </div>
    <?php endif; ?>
<?= $this->endSection(); ?>