<?= $this->extend('page'); ?>
<?= $this->section('content'); ?>
	<?php if($new): ?>
		<h1>Нови рок</h1>
	<?php else: ?>
		<h1>Измени рок</h1>
	<?php endif;?>
	<p>Ако нисте упознати са начином додавања или измене рокова прочитајте прво <a href="/manual">кратко упутство</a>.</p>
	<form style="margin: 1em 0;" method="post" id="form">
		<div class="formRow">
			<div class="formRowElement">
				<label for="subject">Предмет:</label>
			</div>
			<select name="subject" id="subject" class="formRowElement">
				<?= $subjectsList ?>
			</select>
			<div style="margin-left: auto"></div>
			<label for="date" class="formRowElement">Датум:</label>
			<input type="date" name="date" id="date" value="<?= $exam->date ?>">
		</div>
		<div class="formRow">
			<label for="type" class="formRowElement">Колоквијум:</label>
			<input type="checkbox" id="type" name="type[]" value="0" <?= ($exam->type) ? 'checked' : '' ?> class="formRowElement">
			<div style="margin-left: auto"></div>
			<label for="duration" class="formRowElement"><abbr title="Ако трајање није познато, унети 0">Трајање:</abbr></label>
			<input type="number" name="duration" id="duration" value="<?= $exam->duration ?>" style="-webkit-appearance: none; -moz-appearance: textfield;">
		</div>
		<div class="formRow">
			<div class="formRowGroup">
				<label for="">Модул/Смер:</label>
			</div>
			<div class="formRowGroup">
				<input type="checkbox" name="module[]" value="0" <?= ($exam->ma) ? 'checked' : '' ?>>&nbsp;<label><abbr title="Астрономија и астрофизика">А</abbr></label>
			</div>
			<div class="formRowGroup">
				<input type="checkbox" name="module[]" value="1" <?= ($exam->mi) ? 'checked' : '' ?>>&nbsp;<label><abbr title="Информатика">И</abbr></label>
			</div>
			<div class="formRowGroup">
				<input type="checkbox" name="module[]" value="2" <?= ($exam->ml) ? 'checked' : '' ?>>&nbsp;<label><abbr title="Професор математике и рачунарства">Л</abbr></label>
			</div>
			<div class="formRowGroup">
				<input type="checkbox" name="module[]" value="3" <?= ($exam->mm) ? 'checked' : '' ?>>&nbsp;<label><abbr title="Теоријска математика и примене">М</abbr></label>
			</div>
			<div class="formRowGroup">
				<input type="checkbox" name="module[]" value="4" <?= ($exam->mp) ? 'checked' : '' ?>>&nbsp;<label><abbr title="Примењена математика">Н</abbr></label>
			</div>
			<div class="formRowGroup">
				<input type="checkbox" name="module[]" value="5" <?= ($exam->mr) ? 'checked' : '' ?>>&nbsp;<label><abbr title="Рачунарство и информатика">Р</abbr></label>
			</div>
			<div class="formRowGroup">
				<input type="checkbox"  name="module[]" value="6" <?= ($exam->ms) ? 'checked' : '' ?>>&nbsp;<label><abbr title="Статистика, актуарска и финансијска математика">В</abbr></label>
			</div>
		</div>
		<div class="formRow">
			<label for="note">Текст:</label><br>
			<textarea name="note" id="note" rows="5" placeholder="Ово поље садржи информације које су наведене на папиру са задацима а нису могле бити унете кроз форму."><?= $exam->note ?></textarea>
		</div>
		<div class="formRow" style="flex-direction: row-reverse;" id="insertProblemEntry">
			<?php if($new): ?>
				<div class="button smallButton" onclick="newProblemEntry()">Додај задатак</div>
			<?php endif; ?>
		</div>
		<div class="formRow" style="flex-direction: row-reverse;">
			<button type="submit" class="bigButton" onclick="window.onbeforeunload = null">Унеси</button>
		</div>
	</form>
	<script>
		var problems = 0;

		var problemEntryTemplate = "<section class=\"problemEntry\" id=\"pK\">\
		<header>\
		<div>Задатак K</div>\
		<div style=\"margin-left: auto\"></div>\
		<div class=\"button smallButton\" onclick=\"renderProblem(K,true)\">Прегледај</div>\
		<div class=\"button smallButton\" onclick=\"deleteProblemEntry(K)\">Обриши</div>\
		</header>\
		<div id=\"problemDivK\"></div>\
		<textarea id=\"problemEntryK\" name=\"problems[]\" rows=\"5\" placeholder=\"Текст задатка\"></textarea>\
		<div class=\"formRow\">\
		<label class=\"formRowElement\">Поена:</label>\
		<input type=\"number\" name=\"points[]\" style=\"-webkit-appearance: none; -moz-appearance: textfield;\">\
		</div>\
		</section>";

		function newProblemEntry() {
			var template = createElementFromHTML(problemEntryTemplate.replace(/K/g, "" + (problems + 1)));
			document.getElementById('form').insertBefore(template, document.getElementById('insertProblemEntry'));
			problems++;
		}

		function deleteProblemEntry(i) {
			if (confirm('Да ли сте сигурни да желите да обришете овај задатак?')) {
				document.getElementById('p' + i).remove();
				relabel();
				problems--;
			} 
		}

		function createElementFromHTML(htmlString) {
			var div = document.createElement('div');
			div.innerHTML = htmlString.trim();
			return div.firstChild; 
		}

		function relabel(){
			var elements = document.getElementsByClassName('problemEntry');
			for (let i = 0; i < elements.length; i++) {
				var children = elements[i].children;
				children[0].children[0].innerHTML = "Задатак " + (i + 1);
				renderProblem(parseInt(elements[i].id.slice(1)), false);
				children[0].children[2].onclick = () => { renderProblem(i + 1, true); };
				children[0].children[3].onclick = () => { deleteProblemEntry(i + 1); };
				children[1].id = "problemDiv" + (i + 1);
				children[2].id = "problemEntry" + (i + 1);
				elements[i].id = "p" + (i + 1);
			}
		}

		function renderProblem(i, render){
			if (render) {
				document.getElementById('problemDiv' + i).style.display = "block";
				document.getElementById('problemEntry' + i).style.display = "none";
				document.getElementById('problemDiv' + i).innerHTML = document.getElementById('problemEntry' + i).value;
				document.getElementById('p' + i).children[0].children[2].innerHTML = "Измени";
				document.getElementById('p' + i).children[0].children[2].onclick = () => {renderProblem(i, false);}
				renderMathInElement(document.getElementById('problemDiv' + i), {throwOnError: false});
			} else {
				document.getElementById('problemDiv' + i).style.display = "none";
				document.getElementById('problemEntry' + i).style.display = "block";
				document.getElementById('p' + i).children[0].children[2].innerHTML = "Прегледај";
				document.getElementById('p' + i).children[0].children[2].onclick = () => {renderProblem(i, true);}
			}
		}

		function createProblems(data) {
			for (let i = 0; i < data.length; i++) {
				var template = createElementFromHTML(problemEntryTemplate.replace(/K/g, "" + (i + 1)));
				document.getElementById('form').insertBefore(template, document.getElementById('insertProblemEntry'));
				var pi = document.getElementById('p' + (i + 1));
				pi.children[2].value = data[i].text;
				pi.children[3].children[1].value = data[i].points;
			}
		}

		function modifyProblemTemplate() {
			problemEntryTemplate = problemEntryTemplate.replace(
				"<div class=\"button smallButton\" onclick=\"deleteProblemEntry(K)\">Обриши</div>",
				"<div class=\"button smallButton\" onclick=\"deleteProblemEntry(K)\" style=\"display: none\"></div>" );
		}

		<?php if($new): ?>
			var newExam = 1;
		<?php else: ?>
			var newExam = 0;
			var problems = <?= $problems ?>;
			modifyProblemTemplate();
			createProblems(problems);
		<?php endif;?>
			window.onbeforeunload = function(evt) {return true;}
	</script>
<?= $this->endSection(); ?>