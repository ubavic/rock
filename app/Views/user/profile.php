<?= $this->extend('page'); ?>
<?= $this->section('content'); ?>
	<h1><?= $user->name ?></h1>
	<p><a href="mailto:<?= $user->email ?>"><?= $user->email ?></a></p>
    <p>Корисник је регистрован: <?= date_format(date_create($user->created_at), 'd.m.Y.') ?></p>
	<p>Корисник је креирао: <a href="/user/<?= $user->id ?>/exams"> <?= $count ?> рок/рокова </a></p>
	<?php if ($user->id == session()->get('id')): ?>
		<div class="formRow">
			<div class="verticalRowSpacer"></div>
			<a href="/user/settings" class="button bigButton">Измени профил</a>
		</div>
	<?php endif; ?>
<?= $this->endSection(); ?>