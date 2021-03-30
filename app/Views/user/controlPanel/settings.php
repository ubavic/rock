<?= $this->extend('user/controlPanel/layout'); ?>
<?= $this->section('cp_content'); ?>
<div>
	<h2 style="margin-top:0">Профил</h2>
	<?php if (isset($validation)): ?>
		<div class="formRow error">
			<?= $validation->listErrors() ?>
		</div>
	<?php endif; ?>
	<?php if (session()->get('success')): ?>
		<div class="formRow success">
			<?= session()->get('success'); ?>
		</div>
	<?php endif; ?>
	<form action="/user/settings" method="post">
		<p>У наредној форми можете променити своје име. Ваше име, као и Ваш <i>e-mail</i>, је видљиво само другим члановима сајта. Пожељно је, али не и обавезно, да за име упишете Ваше лично име, на ћирилици.</p>
		<div class="formRow">
			<label for="name" style="width: 4em;">Име</label>
			<input name="name" id="name" style="width: 20em;" value="<?= $name ?>">
		</div>
		<div class="formRow">
			<span style="width: 4em;"><i>E-mail</i></span>
			<span style="width: 20em;"><?= $email ?></span>
		</div>
		<div class="formRow">
			<button class="smallButton" type="submit" value="changeName">Сачувај</button>
		</div>
	</form>
	<h4>Промени шифру</h4>
	<form action="/user/settings" method="post">
		<div class="formRow">
			<label for="password" style="width: 8em;">Шифра</label>
			<input type="password" name="password" id="password" style="width: 20em;">
		</div>
		<div class="formRow">
			<span for="pass_confirm" style="width: 8em;">Понови шифру</span>
			<input type="password" name="pass_confirm" id="pass_confirm" style="width: 20em;">
		</div>
		<div class="formRow">
			<button class="smallButton" type="submit" value="changePassword">Сачувај</button>
		</div>
	</form>
</div>
<?= $this->endSection(); ?>