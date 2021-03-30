<?= $this->extend('page'); ?>
<?= $this->section('content'); ?>
	<h1><?= $user->name ?></h1>
	<p><a href="mailto:<?= $user->email ?>"><?= $user->email ?></a></p>
    <p>Корисник је регистрован: <?= date_format(date_create($user->created_at), 'd.m.Y.') ?></p>
<?= $this->endSection(); ?>