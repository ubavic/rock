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
			<a href="/cp/settings" <?=($uri->getSegment(2) == 'settings' ? $color : null)?> >Подешавања</a>
			<a href="/cp/savedExams" <?=($uri->getSegment(2) == 'savedExams' ? $color : null)?>>Сачувани&nbsp;рокови</a>
			<?php if (session()->get('can_manage_users')): ?>
				<div>Aдминистрација</div>
				<a href="/cp/all" <?=($uri->getSegment(2) == 'all' ? $color : null)?> >Корисници</a>
				<a href="/cp/log" <?=($uri->getSegment(2) == 'log' ? $color : null)?> >Лог</a>
			<?php endif; ?>
			<?php if (session()->get('can_manage_subjects')): ?>
				<div>Предмети</div>
				<a href="/subject">Сви предмети</a>
			<?php endif; ?>
			<div>Остало</div>
			<a href="/tools">Алати</a>
			<a href="/manual">Упутство</a>
		</nav>
		<?= $this->renderSection('cp_content'); ?>
	</div>
<?= $this->endSection(); ?>