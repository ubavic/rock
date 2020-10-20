<main>
	<h2>Нови рок</h2>
	<form action="" style="margin: 1em 0;" method="post" id="form">
		<?php if (isset($validation)): ?>
			<div class="formRow error">
				<?= $validation->listErrors() ?>
			</div>
		<?php endif; ?>
		<div class="formRow">
			<div class="formRowElement">
				<label for="subject">Предмет:</label>
			</div>
			<select name="subject" id="subject" value="<?= $exam->subject ?>" class="formRowElement">
				<?= $subjectsList ?>
			</select>
			<div style="margin-left: auto"></div>
			<label for="date" class="formRowElement">Датум:</label>
			<input type="date" name="date" id="date" value="<?= $exam->date ?>">
		</div>
		<div class="formRow">
			<label for="type" class="formRowElement">Колоквијум:</label>
			<input type="checkbox" id="type" name="type[]" value="1" class="formRowElement">
			<div style="margin-left: auto"></div>
			<label for="duration" class="formRowElement"><abbr title="Ако трајање није познато, унети 0">Трајање:</abbr></label>
			<input type="number" name="duration" id="duration" value="<?= $exam->duration ?>" style="-webkit-appearance: none; -moz-appearance: textfield;">
		</div>
		<div class="formRow">
			<div class="formRowGroup">
				<label for="">Модул/Смер:</label>
			</div>
			<div class="formRowGroup">
				<input type="checkbox" name="module[]" value="0" <?= ($exam->modules_array[0]) ? 'checked' : '' ?>>&nbsp;<label><abbr title="Астрономија и астрофизика">АА</abbr></label>
			</div>
			<div class="formRowGroup">
				<input type="checkbox" name="module[]" value="1" <?= ($exam->modules_array[1]) ? 'checked' : '' ?>>&nbsp;<label><abbr title="Информатика">И</abbr></label>
			</div>
			<div class="formRowGroup">
				<input type="checkbox" name="module[]" value="2" <?= ($exam->modules_array[2]) ? 'checked' : '' ?>>&nbsp;<label><abbr title="Професор математике и рачунарства">МЛ</abbr></label>
			</div>
			<div class="formRowGroup">
				<input type="checkbox" name="module[]" value="3" <?= ($exam->modules_array[3]) ? 'checked' : '' ?>>&nbsp;<label><abbr title="Теоријска математика и примене">ММ</abbr></label>
			</div>
			<div class="formRowGroup">
				<input type="checkbox" name="module[]" value="4" <?= ($exam->modules_array[4]) ? 'checked' : '' ?>>&nbsp;<label><abbr title="Примењена математика">МП</abbr></label>
			</div>
			<div class="formRowGroup">
				<input type="checkbox" name="module[]" value="5" <?= ($exam->modules_array[5]) ? 'checked' : '' ?>>&nbsp;<label><abbr title="Рачунарство и информатика">МР</abbr></label>
			</div>
			<div class="formRowGroup">
				<input type="checkbox"  name="module[]" value="6" <?= ($exam->modules_array[6]) ? 'checked' : '' ?>>&nbsp;<label><abbr title="Статистика, актуарска и финансијска математика">МС</abbr></label>
			</div>
		</div>
		<div class="formRow">
			<label for="note">Напомена:</label><br>
			<textarea name="note" id="note" rows="5" placeholder="Напомена садржи информације које су наведене на папиру са задацима а нису могле бити унете кроз форму."><?= $exam->note ?></textarea>
		</div>
		<div class="formRow">
			<label for="additional_note">Додатна напомена:</label><br>
			<textarea name="additional_note" id="additional_note" rows="5" placeholder="Додатне напомена садржи све остале информације о року (нпр ако неки од задатака има грешку поставци, итд...)."><?= $exam->additional_note ?></textarea>
		</div>
		<div class="formRow" style="flex-direction: row-reverse;" id="insertProblemEntry">
			<div class="button smallButton" onclick="newProblemEntry()">Додај задатак</div>
		</div>
		<div class="formRow" style="flex-direction: row-reverse;">
			<button type="submit" class="bigButton">Унеси</button>
		</div>
	</form>
</main>