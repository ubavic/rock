<!DOCTYPE html>
<html lang="sr">
	<head>
		<meta charset="UTF-8">
		<title><?= $TITLE ?> • МАТФ РОКОВИ</title>
		<?php if(isset($DESCRIPTION)): ?>
			<meta name="description" content="<?= $DESCRIPTION ?>">
		<?php else: ?>
			<meta name="description" content="Сајт на коме можете прегледати досадашње испитне рокове и колоквијуме на Математичком факултету у Београду.">
		<?php endif; ?>
		<meta name="author" content="MATF Rokovi">
		<meta name="viewport" content="width=device-width, user-scalable=yes">
		<link rel="stylesheet" type="text/css" href="/css/style.css">
		<link rel="stylesheet" type="text/css" href="/katex/katex.min.css">
		<link rel="stylesheet" type="text/css" href="/katex/copy-tex.min.css">
		<link rel="stylesheet" type="text/css" media="print" href="/css/print.css">
		<link rel="apple-touch-icon" sizes="180x180" href="/img/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="/img/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="/img/favicon-16x16.png">
		<link rel="manifest" href="/site.webmanifest">
		<link rel="mask-icon" href="/img/safari-pinned-tab.svg" color="#771d1d">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="theme-color" content="#ffffff">
		<meta property="og:image" content="https://rokovi.ubavic.rs/img/logo.png"/>
		<script>
			var menuStatus = 0;
			function swichMenu() {
				var items = document.getElementsByClassName("menuItem");
				if (menuStatus == 1) {
					for (var i = 1; i < items.length; i++) {
						items[i].removeAttribute("style");
					}
					document.getElementById("menuSwitch").style.backgroundColor = "transparent";
					menuStatus = 0;
				} else {
					for (var i = 1; i < items.length; i++) {
						items[i].style.display = "inline-block";
					}
					document.getElementById("menuSwitch").style.backgroundColor = "var(--color-blue-2)";
					menuStatus = 1;
				}
			}
		</script>
	</head>
	<body>
<?php 
	$uri = service('uri');
	$uri->setSilent();
?>
		<header>
			<div id="title">МАТФ РОКОВИ</div>
			<nav>
				<div onclick="swichMenu()" title="Отвори мени" class="menuItem" id="menuSwitch">Мени</div>
				<a href="/" title="Вратите се на почетну." class="menuItem <?= ($uri->getSegment(1) == null ? 'activeMenuItem' : null) ?>">Почетна</a>
				<a href="/exam" title="Претражите све доступне рокове." class="menuItem <?= ($uri->getSegment(1) == 'exam' ? 'activeMenuItem' : null) ?>">Рокови</a>
				<a href="/about" title="Информације о пројекту." class="menuItem <?= ($uri->getSegment(1) == 'about' ? 'activeMenuItem' : null) ?>">О&nbsp;Пројекту</a>
				<div style="margin-left: auto"></div>
				<?php if(session()->get('logged')): ?>
					<a href="/user/settings" title="Контролни панел" class="menuItem <?= ($uri->getSegment(1) == 'user' ? 'activeMenuItem' : null) ?>">Контролни&nbsp;панел</a>
				<?php else: ?>
					<a href="/user/login" title="Пријава и регистација" class="menuItem">Пријавите&nbsp;се</a>
				<?php endif;?>
			</nav>
		</header>
