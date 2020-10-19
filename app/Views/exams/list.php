<main>
	<h2>Претражи рокове</h2>
	<form action="">
		<div class="formRow">
			<label for="subject" class="formRowElement">Предмет:</label>&nbsp;
			<select name="subject" id="subject" class="formRowElement">
					<?= $subjectsList ?>
			</select>
			</div>
		</div>
	</form>
	<div class="examList">
		<div class="examListHeader">
			<div class="examListType"><abbr title="Испит/колоквијум">Тип</abbr></div>
			<div class="examListSubject">Предмет</div>
			<div class="examListDate">Датум</div>
			<div class="examListModules">Смер</div>
		</div>
		<div id="listData">
		</div>
	</div>
	<?php if(session()->get('logged')): ?>
		<div class="formRow" style="flex-direction: row-reverse;">
			<a href="/exam/new" class="bigButton">Нови рок</a>
		</div>
	<?php endif; ?>
</main>
<script>

getExams();
document.getElementById("subject").onchange = () => {getExams()};

function getExams () {
	var subject = document.getElementById("subject").value;
	var request = ("<?= base_url() . '/exam/getExams/' ?>" + subject);

	fetch(request)
	.then((response) => {
		return response.text();
  		})
  	.then((data) => {
    	document.getElementById("listData").innerHTML = data;
		});
	}
</script>
