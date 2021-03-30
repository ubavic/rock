<?= $this->extend('page'); ?>
<?= $this->section('content'); ?>
	<h1>Испитни рокови</h1>
	<p>На овом сајту можете пронаћи испитне рокове одржане на Математичком факултету у Београду. Испитне рокове можете претраживати на страници <a href="/exam">Рокови</a>.</p>
	<h2>Последње додати рокови</h2>
	<?= $examsTable ?>
	<h2>Статистика</h2>
	<div style="display: flex; flex-direction: row; justify-content: space-around; flex-wrap: wrap">
		<div style="text-align: center; margin: 0 1em">
			РОКОВА:
			<div style="font-size: 2em; color: var(--color-blue-4); font-weight: bold;">
				<?= $numberOfExams ?>
			</div>
		</div>
		<div style="text-align: center; margin: 0 1em">
			ЗАДАТАКА:
			<div style="font-size: 2em; color: var(--color-blue-4); font-weight: bold;">
				<?= $numberOfProblems ?>
			</div>
		</div>
		<div style="text-align: center; margin: 0 1em">
			ЧЛАНОВА:
			<div style="font-size: 2em; color: var(--color-blue-4); font-weight: bold;">
				<?= $numberOfUsers ?>
			</div>
		</div>
	</div>
<?= $this->endSection(); ?>