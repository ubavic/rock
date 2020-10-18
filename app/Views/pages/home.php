<main>
	<h2>Испитни рокови</h2>
	<p>На овом сајту можете пронћи испитне рокове одржане на Математичком факултету у Београду. Испитне рокове можете претраживати на старници <a href="/exam">Рокови</a>.</p>
	<h3>Последње додати рокови</h3>
	<div class="examList">
		<div class="examListHeader">
			<div class="examListType"><abbr title="Испит/колоквијум">Тип</abbr></div>
			<div class="examListSubject">Предмет</div>
			<div class="examListDate">Датум</div>
			<div style="margin-left:auto"></div>
			<div>Смер</div>
		</div>
		<?php if(empty($exams)): ?>
			<div style="text-align: center; padding: 1em; max-width: 600px; margin: 0 auto;">
				Нису пронађени рокови за унети критеријум. <br>
				Имате рок који ми немамо? Пошаљите нам га <a href="/about#contact">електорнском поштом</a> и поставићемо га у најкраћем року.
			</div>
		<?php else: ?>
			<?php foreach ($exams as $exam): ?>
				<a href="<?= '/exam/view/' . $exam->id ?>" class="examListRow" >
					<div class="examListType"><?= ($exam->type == 0) ? 'И' : 'К' ?></div>
					<div class="examListSubject"><?= $exam->subject_name ?></div>
					<div class="examListDate"><?= $exam->date ?></div>
					<div style="margin-left:auto"></div>
					<div><?= $exam->modules_string ?></div>
				</a>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
	<h3>Статистика</h3>
	<div style="display: flex; flex-direction: row; justify-content: space-around; flex-wrap: wrap">
		<div style="text-align: center; margin: 0 1em 0 0">
			ПРЕДМЕТА:
			<div style="font-size: 2em; color: var(--color-blue-4); font-weight: bold;">
				<?= $numberOfSubjects ?>
			</div>
			
		</div>
		<div style="text-align: center; margin: 0 1em 0 1em">
			РОКОВА:
			<div style="font-size: 2em; color: var(--color-blue-4); font-weight: bold;">
				<?= $numberOfExams ?>
			</div>
		</div>
		<div style="text-align: center; margin: 0 1em 0 1em">
			ЗАДАТАКА:
			<div style="font-size: 2em; color: var(--color-blue-4); font-weight: bold;">
				<?= $numberOfProblems ?>
			</div>
		</div>
		<div style="text-align: center; margin: 0 0 0 1em">
			ЧЛАНОВА:
			<div style="font-size: 2em; color: var(--color-blue-4); font-weight: bold;">
				<?= $numberOfUsers ?>
			</div>
		</div>
	</div>
</main>