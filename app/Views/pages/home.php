<main>
	<h2>Испитни рокови</h2>
	<p>На овом сајту можете пронћи испитне рокове одржане на Математичком факултету у Београду. Испитне рокове можете претраживати на старници <a href="/exam">Рокови</a>.</p>
	<h3>Последње додати рокови</h3>
	<?= $examsTable ?>
	<h3>Статистика</h3>
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
</main>