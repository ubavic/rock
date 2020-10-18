<main>
	<h2>Претражи рокове</h2>
	<form action="" style="margin: 1em 0;">
		<div class="formRow">
			<label for="subject" class="formRowElement">Предмет:</label>&nbsp;
			<select name="subject" id="subject" class="formRowElement">
					<?= $subjectsList ?>
			</select>
			</div>
		</div>
		<div class="formRow">
			<div class="formRowElement">
				<label for="">Модул/Смер:</label>
			</div>
			<div class="formRowGroup">
				<input type="checkbox" id="ML" name="ML">&nbsp;<label for="ML"><abbr title="Професор математике и рачунарства">МЛ</abbr></label>
			</div>
			<div class="formRowGroup">
				<input type="checkbox" id="MM" name="MM">&nbsp;<label for="MM"><abbr title="Теоријска математика и примене">ММ</abbr></label>
			</div>
			<div class="formRowGroup">
				<input type="checkbox" id="MR" name="MR">&nbsp;<label for="MR"><abbr title="Рачунарство и информатика">МР</abbr></label>
			</div>
			<div class="formRowGroup">
				<input type="checkbox" id="MP" name="MP">&nbsp;<label for="MP"><abbr title="Примењена математика">МП</abbr></label>
			</div>
			<div class="formRowGroup">
				<input type="checkbox" id="MS" name="MS">&nbsp;<label for="MS"><abbr title="Статистика, актуарска и финансијска математика">МС</abbr></label>
			</div>
			<div class="formRowGroup">
				<input type="checkbox" id="I" name="I">&nbsp;<label for="I"><abbr title="Информатика">И</abbr></label>
			</div>
			<div class="formRowGroup">
				<input type="checkbox" id="AA" name="AA">&nbsp;<label for="AA"><abbr title="Астрономија и астрофизика">АА</abbr></label>
			</div>
		</div>
	</form>
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
			<?php foreach ($exams as &$exam): ?>
				<a href="<?= '/exam/view/' . $exam->id ?>" class="examListRow" >
					<div class="examListType"><?= ($exam->type == 0) ? 'И' : 'К' ?></div>
					<div class="examListSubject"><?= $exam->subject_name ?></div>
					<div class="examListDate"><?= $exam->date ?></div>
					<div style="margin-left:auto"></div>
					<div class="examListModules"><?= $exam->modules_string ?></div>
				</a>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
	<?php if(session()->get('logged')): ?>
		<div class="formRow" style="flex-direction: row-reverse;">
			<a href="/exam/new" class="bigButton">Нови рок</a>
		</div>
	<?php endif; ?>
</main>
