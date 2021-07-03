<?php 
	$uri = service('uri');
	$uri->setSilent();
	$color = 'style="background-color: var(--color-gray-4); font-weight:bold"';
?>
<?= $this->extend('page'); ?>
<?= $this->section('content'); ?>
	<h1>Кориснички контролни панел</h1>
	<div class="controlPanel">
		<nav>
			<a href="/user/settings" <?=($uri->getSegment(2) == 'settings' ? $color : null)?> >Подешавања</a>
			<?php if (session()->get('can_manage_users')): ?>
				<div>Aдминистрација</div>
				<a href="/user/all" <?=($uri->getSegment(2) == 'all' ? $color : null)?> >Корисници</a>
				<a href="/user/log" <?=($uri->getSegment(2) == 'log' ? $color : null)?> >Лог</a>
			<?php endif; ?>
			<div>Остало</div>
			<a href="/exam/saved">Сачувани&nbsp;рокови</a>
			<a href="/tools">Алати</a>
			<a href="/manual">Упутство</a>
		</nav>
		<?= $this->renderSection('cp_content'); ?>
	</div>
<?= $this->endSection(); ?>