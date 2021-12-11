<?= $this->extend('page'); ?>
<?= $this->section('content'); ?>
	<div class="breadcrumb">
		<div>
			<a href="/exam"><i>Сви рокови</i></a>&nbsp;&bull;&nbsp;
			<a href="/exam/<?= $subject->id ?>"><i><?= $subject->name ?></i></a>:
		</div>
	</div>
	<h1>Генериши рок</h1>
	<p>Уз помоћ ове странице можете генерисати насумични рок.
		Рок се генерише случајним избором задатака који постоје у бази за предмет <em><?= $subject->name ?></em>.</p>
	<form method="post" action="/exam/generate">
		<div class="formRow">
			<div class="formRowElement">
				<label for="subject">Број задатака:</label>
			</div>
			<div class="formRowElement">
				<input type="number" name="problems" min="2" max="10" value="5" style="-webkit-appearance: none; -moz-appearance: textfield; width: 5em">
			</div>
			<div class="formRowElement" style="font-size: 0.9em;">
				(најмање 2 а највише 10 задатака)
			</div>
		</div>
		<div class="formRow" style="flex-direction: row-reverse;">
			<input type="hidden" id="subject" name="subject" value="<?= $subject->id ?>">
			<button type="submit" class="bigButton" onclick="window.onbeforeunload = null">Генериши</button>
		</div>
	</form>
<?= $this->endSection(); ?>
