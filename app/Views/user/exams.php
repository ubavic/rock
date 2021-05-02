<?= $this->extend('page'); ?>
<?= $this->section('content'); ?>
	<h1><?= $user->name ?></h1>
    <?= $createdExams ?>
<?= $this->endSection(); ?>