<?php if(empty($exams)): ?>
	<div style="text-align: center; padding: 1em; max-width: 600px; margin: 0 auto;">
		Нису пронађени рокови за унети критеријум. <br>
		Имате рок који ми немамо? Пошаљите нам га <a href="/about#contact">електорнском поштом</a> и поставићемо га у најкраћем року.
	</div>
<?php else: ?>
	<?php foreach ($exams as &$exam): ?>
		<a href="<?= '/exam/view/' . $exam->id ?>" class="examListRow" >
			<div class="examListType"><?= ($exam->type == 0) ? 'И' : 'К' ?></div>
			<div class="examListSubject"><?= $exam->subject_name ?></div>
			<div class="examListDate"><?= $exam->date ?></div>
			<div class="examListModules"><?= $exam->modules_string ?></div>
		</a>
	<?php endforeach; ?>
<?php endif; ?>