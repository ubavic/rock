<main>
	<h2>Претражи рокове</h2>
	<form>
		<div class="formRow">
			<label for="subject" class="formRowElement">Предмет:</label>&nbsp;
			<select name="subject" id="subject" class="formRowElement">
					<?= $subjectsList ?>
			</select>
		</div>
	</form>
	<?= $exam_table ?>
	<?php if($can_add): ?>
		<div class="formRow" style="flex-direction: row-reverse;">
			<a href="/exam/new" class="button bigButton">Нови рок</a>
		</div>
	<?php endif; ?>
</main>
<script>
document.getElementById("subject").onchange = () => {document.location.href = ("<?= base_url()?>/exam/" + document.getElementById("subject").value);};
</script>
