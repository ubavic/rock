<!DOCTYPE html>
<html lang="sr">
<head>
	<meta charset="utf-8">
	<title>404 Page Not Found</title>
	<link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body>
	<header>
		<h1>МАТФ РОКОВИ</h1>
		<nav>
			<a href="/" title="Вратите се на почетну." class="menuItem">Почетна</a>
			<a href="/exam" title="Претражите све доступне рокове." class="menuItem">Рокови</a>
			<a href="/about" title="Информације о пројекту." class="menuItem">О Пројекту</a>
		</nav>
	</header>
	<main>
		<h2>404 - <i>File Not Found</i></h2>
		<p>
			<?php if (! empty($message) && $message !== '(null)') : ?>
				<?= esc($message) ?>
			<?php else : ?>
				Не можемо да пронађемо страницу коју сте затражили.
			<?php endif ?>
		</p>
	</main>
</body>
</html>
