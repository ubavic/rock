<main>
	<div style="display: flex; flex-direction: row">
		<div style="margin-left: auto"></div>
		<div>
			<?= $exam->date ?>
		</div>
	</div>
	<div class="examTitle">
		<div class="heading">
			<?php if ($exam->type == 0): ?>
				Писмени испит из предмета
			<?php else: ?>
				Колоквијум из предмета
			<?php endif; ?>
		</div>
		<div class="class">
		   <?= $exam->subject_name ?>
		</div>
	</div>
	<div class="formRow">
		<?php if($exam->modules_string): ?>
			<div>
				За смерове: <?= $exam->modules_string ?>
			</div>
		<?php endif ?>
		<div style="margin-left: auto"></div>
		<?php if($exam->duration): ?>
			<div>
				Време израде: <?= $exam->duration ?> минута.
			</div>
		<?php endif; ?>
	</div>
	<?php if ($exam->note != NULL): ?>
		<p>
			<strong>Напомена:</strong> <?= $exam->note ?>
		</p>
	<?php endif; ?>
	<?php if ($exam->additional_note != NULL): ?>
		<p>
			<strong>Додатна напопомена:</strong> <?= $exam->additional_note ?>
		</p>
	<?php endif; ?> 
	<div class="problems">
		<?php for ($i = 0; $i < count($problems); $i++): ?>
			<section class="problem">
				<header><a href="#p<?= $i + 1 ?>" id="p<?= $i + 1 ?>"><?= $i + 1 ?></a></header>
				<?= $problems[$i]->text ?>
			</section>
		<?php endfor; ?>
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
			<?php endif; ?>
        </div>
    <?php endif; ?>
</main>